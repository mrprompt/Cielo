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

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;

/**
 * Requisição de autorizacao de portador
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class IdentificacaoTransacao extends Requisicao
{
    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const ID = 6;

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
    public function __construct(
        Autorizacao $autorizacao,
        Transacao $transacao,
        Cartao $cartao
    ) {
        $this->cartao = $cartao;

        parent::__construct($autorizacao, $transacao);
    }

    /**
     * {@inheritdoc}
     */
    protected function getXmlInicial()
    {
        return sprintf(
            '<%s id="%d" versao="%s"></%s>',
            'requisicao-tid',
            self::ID,
            Cliente::VERSAO,
            'requisicao-tid'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configuraEnvio()
    {
        $this->adicionaFormaPagamento();
    }

    /**
     * {@inheritdoc}
     */
    protected function deveAdicionarTid()
    {
        return false;
    }

    /**
     * Adiciona os dados da forma de pagamento à requisição
     */
    protected function adicionaFormaPagamento()
    {
        $formaPgto  = $this->getEnvio()->addChild('forma-pagamento', '');

        $formaPgto->addChild('bandeira', $this->cartao->getBandeira());
        $formaPgto->addChild('produto', $this->transacao->getProduto());
        $formaPgto->addChild('parcelas', $this->transacao->getParcelas());
    }
}
