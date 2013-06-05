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
class AutorizacaoPortador extends Requisicao
{
    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const ID = 7;

    /**
     * Cartão a ser utilizado
     *
     * @var Cartao
     */
    private $cartao;

    /**
     * Idioma a ser utilizado
     *
     * @var string
     */
    private $idioma;

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
        Cartao $cartao,
        $idioma
    ) {
        $this->cartao = $cartao;
        $this->idioma = $idioma;

        parent::__construct($autorizacao, $transacao);
    }

    /**
     * {@inheritdoc}
     */
    protected function getXmlInicial()
    {
        return sprintf(
            '<%s id="%d" versao="%s"></%s>',
            'requisicao-autorizacao-portador',
            self::ID,
            Cliente::VERSAO,
            'requisicao-autorizacao-portador'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configuraEnvio()
    {
        $this->adicionaCartao();
        $this->adicionaTransacao();
        $this->adicionaFormaPagamento();

        $this->getEnvio()->addChild('capturar-automaticamente', $this->transacao->getCapturar());
        $this->getEnvio()->addChild('campo-livre', '');
    }

    /**
     * Adiciona os dados do cartão à requisição
     */
    protected function adicionaCartao()
    {
        $dadosCartao = $this->getEnvio()->addChild('dados-cartao', '');

        $dadosCartao->addChild('numero', $this->cartao->getCartao());
        $dadosCartao->addChild('validade', $this->cartao->getValidade());
        $dadosCartao->addChild('indicador', $this->cartao->getIndicador());
        $dadosCartao->addChild('codigo-seguranca', $this->cartao->getCodigoSeguranca());
        $dadosCartao->addChild('nome-portador', $this->cartao->getNomePortador());
    }

    /**
     * Adiciona os dados da transação à requisição
     */
    protected function adicionaTransacao()
    {
        $dadosTransacao = $this->getEnvio()->addChild('dados-pedido', '');

        $dadosTransacao->addChild('numero', $this->transacao->getTid());
        $dadosTransacao->addChild('valor', $this->transacao->getValor());
        $dadosTransacao->addChild('moeda', $this->transacao->getMoeda());
        $dadosTransacao->addChild('data-hora', $this->transacao->getDataHora());
        $dadosTransacao->addChild('descricao', $this->transacao->getDescricao());
        $dadosTransacao->addChild('idioma', $this->idioma);
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
