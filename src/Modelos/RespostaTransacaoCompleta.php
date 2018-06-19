<?php
/**
 * RespostaTransacaoCompleta
 *
 * Dados do RespostaTransacaoCompleta.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage RespostaTransacaoCompleta
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Modelos;

use DateTime;
use JMS\Serializer\Annotation as Serializer;
use MrPrompt\Cielo\Transacao;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use InvalidArgumentException;

/**
 * Class RespostaTransacaoCompleta
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class RespostaTransacaoCompleta
{
    /**
     * @Type("string")
     * @var string
     */
    private $tid;

    /**
     * @Type("string")
     * @var string
     */
    private $pan;

    /**
     * @Type("integer")
     * @var integer
     */
    private $status;

    /**
     * @SerializedName("dados-pedido")
     * @Type("MrPrompt\Cielo\Modelos\DadosPedido")
     * @var \MrPrompt\Cielo\Modelos\DadosPedido
     */
    private $dadosPedido;

    /**
     * @SerializedName("forma-pagamento")
     * @Type("MrPrompt\Cielo\Modelos\FormaPagamento")
     * @var \MrPrompt\Cielo\Modelos\FormaPagamento
     */
    private $formaPagamento;

    /**
     * @Type("MrPrompt\Cielo\Modelos\Autenticacao")
     * @var \MrPrompt\Cielo\Modelos\Autenticacao
     */
    private $autenticacao;

    /**
     * @Type("MrPrompt\Cielo\Modelos\Autorizacao")
     * @var \MrPrompt\Cielo\Modelos\Autorizacao
     */
    private $autorizacao;

    /**
     * @Type("MrPrompt\Cielo\Modelos\Captura")
     * @var \MrPrompt\Cielo\Modelos\Captura
     */
    private $captura;

    /**
     *
     * @Type("MrPrompt\Cielo\Modelos\Token")
     * @var \MrPrompt\Cielo\Modelos\Token
     */
    private $token;

    /**
     * Construtor
     *
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     */
    public function setTid($tid)
    {
        $this->tid = $tid;
    }

    /**
     * @return string
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param string $pan
     */
    public function setPan($pan)
    {
        $this->pan = $pan;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return DadosPedido
     */
    public function getDadosPedido()
    {
        return $this->dadosPedido;
    }

    /**
     * @param DadosPedido $dadosPedido
     */
    public function setDadosPedido($dadosPedido)
    {
        $this->dadosPedido = $dadosPedido;
    }

    /**
     * @return FormaPagamento
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * @param FormaPagamento $formaPagamento
     */
    public function setFormaPagamento($formaPagamento)
    {
        $this->formaPagamento = $formaPagamento;
    }


    /**
     * @return \Autenticacao
     */
    public function getAutenticacao()
    {
        return $this->autenticacao;
    }

    /**
     * @param \Autenticacao $autenticacao
     */
    public function setAutenticacao($autenticacao)
    {
        $this->autenticacao = $autenticacao;
    }

    /**
     * @return \Autorizacao
     */
    public function getAutorizacao()
    {
        return $this->autorizacao;
    }

    /**
     * @param \Autorizacao $autorizacao
     */
    public function setAutorizacao($autorizacao)
    {
        $this->autorizacao = $autorizacao;
    }

    /**
     * @return \Captura
     */
    public function getCaptura()
    {
        return $this->captura;
    }

    /**
     * @param \Captura $captura
     */
    public function setCaptura($captura)
    {
        $this->captura = $captura;
    }

    /**
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param Token $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Retorna um objeto transação com seus respectivos valores populado.
     *
     * @return Transacao
     */
    public function asTransacao() : Transacao
    {
        $transacao = new Transacao();

        $transacao->setTid( $this->getTid() );
        $transacao->setProduto( $this->getProduto() );
        $transacao->setParcelas( $this->getParcelas() );
        $transacao->setMoeda( $this->getMoeda());
        $transacao->setDataHora( $this->getDataHora() );
        $transacao->setNumero( $this->getNumero() );
        $transacao->setValor( $this->getValor() );
        $transacao->setDescricao( $this->getDescricao() );
        $transacao->setToken( $this->getCodigoToken() );
        $transacao->setAutenticacao( $this->getAutenticacao() );
        $transacao->setAutorizacao( $this->getAutorizacao() );
        $transacao->setCaptura( $this->getCaptura() );

        return $transacao;
    }

    /**
     * @return string
     */
    private function getDescricao(){

        return $this->getDadosPedido()
            ->getDescricao();
    }

    /**
     * @return int
     */
    private function getValor(){

        return $this->getDadosPedido()
            ->getValor();
    }

    /**
     * @return int
     */
    private function getNumero(){

        return $this->getDadosPedido()
            ->getNumero();
    }

    /**
     * @return DateTime
     */
    private function getDataHora(){

        return $this->getDadosPedido()
            ->getDataHora();
    }

    /**
     * @return int
     */
    private function getMoeda(){

        return $this->getDadosPedido()
            ->getMoeda();
    }

    /**
     * @return string
     */
    private function getCodigoToken(){

        return $this->getToken()
            ->getDadosToken()
            ->getCodigoToken();
    }

    /**
     * @return string
     */
    private function getProduto(){

        return $this->getFormaPagamento()
            ->getProduto();
    }

    /**
     * @return int
     */
    private function getParcelas(){

        return $this->getFormaPagamento()
            ->getParcelas();
    }
}
