<?php
/**
 * Cielo
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Cliente
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */

namespace MrPrompt\Cielo\Requisicao;

use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Autorizacao;

/**
 * Requisição do token para um determinado cartão de crédito
 *
 * @author Antonio Carlos Ribeiro <acr@antoniocarlosribeiro.com>
 */
class SolicitacaoToken extends Requisicao
{
    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const ID = 8;

    /**
     * Cartão a ser utilizado
     *
     * @var Cartao
     */
    private $cartao;

    /**
     * Inicializa o objeto
     *
     * @param Autorizacao $autorizacao
     * @param Transacao   $transacao
     * @param Cartao      $cartao
     * @param string      $idioma
     */
    public function __construct(Autorizacao $autorizacao, Transacao $transacao, Cartao $cartao) {
        $this->cartao = $cartao;

        $this->setAdicionarTid(false);

        parent::__construct($autorizacao, $transacao);
    }

    /**
     * {@inheritdoc}
     */
    protected function getXmlInicial()
    {
        return sprintf(
            '<%s id="%d" versao="%s"></%s>',
            'requisicao-token',
            self::ID,
            Cliente::VERSAO,
            'requisicao-token'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configuraEnvio()
    {
        $this->adicionaCartao();
    }

    /**
     * Adiciona os dados do cartão à requisição
     */
    protected function adicionaCartao()
    {
        $dadosCartao = $this->getEnvio()->addChild('dados-portador', '');

        $dadosCartao->addChild('numero', $this->cartao->getCartao());
        $dadosCartao->addChild('validade', $this->cartao->getValidade());

        $nomePortador = $this->cartao->getNomePortador();
        if (!empty($nomePortador))
            $dadosCartao->addChild('nome-portador', $nomePortador);
    }

}
