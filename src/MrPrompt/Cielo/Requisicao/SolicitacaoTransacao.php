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
use InvalidArgumentException;

/**
 * Requisição de autorizacao de portador
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class SolicitacaoTransacao extends Requisicao
{
    /**
     * Identificador de chamada do tipo transacao
     *
     * @const integer
     */
    const ID = 1;

    /**
     * Cartão a ser utilizado
     *
     * @var Cartao
     */
    private $cartao;

    /**
     * URL de retorno
     *
     * @var string
     */
    private $urlRetorno;

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
     * @param string      $urlRetorno
     * @param string      $idioma
     */
    public function __construct(
        Autorizacao $autorizacao,
        Transacao $transacao,
        Cartao $cartao,
        $urlRetorno,
        $idioma
    ) {
        if (filter_var($urlRetorno, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) == false) {
            throw new InvalidArgumentException('URL de retorno inválida.');
        }

        $this->cartao = $cartao;
        $this->urlRetorno = substr($urlRetorno, 0, 1024);
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
            'requisicao-transacao',
            self::ID,
            Cliente::VERSAO,
            'requisicao-transacao'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configuraEnvio()
    {
        $this->adicionaPortador();
        $this->adicionaTransacao();
        $this->adicionaFormaPagamento();

        $this->getEnvio()->addChild('url-retorno', $this->urlRetorno);
        $this->getEnvio()->addChild('autorizar', $this->transacao->getAutorizar());
        $this->getEnvio()->addChild('capturar', $this->transacao->getCapturar());
        $this->getEnvio()->addChild('campo-livre', '');
        $this->getEnvio()->addChild('bin', substr($this->cartao->getCartao(), 0, 6));
    }

    /**
     * {@inheritdoc}
     */
    protected function deveAdicionarTid()
    {
        return false;
    }

    /**
     * Adiciona os dados do cartão à requisição
     */
    protected function adicionaPortador()
    {
        $dadosPortador = $this->getEnvio()->addChild('dados-portador', '');

        $dadosPortador->addChild('numero', $this->cartao->getCartao());
        $dadosPortador->addChild('validade', $this->cartao->getValidade());
        $dadosPortador->addChild('indicador', $this->cartao->getIndicador());
        $dadosPortador->addChild('codigo-seguranca', $this->cartao->getCodigoSeguranca());
        $dadosPortador->addChild('nome-portador', $this->cartao->getNomePortador());
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
