<?php
/**
 * Cartao
 *
 * Representação do cartão de crédito a ser utilizado nas transações do cliente.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Cartao
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
namespace MrPrompt\Cielo;

/**
 * @uses MrPrompt\Cielo\Cartao\Exception
 */
use MrPrompt\Cielo\Cartao\Exception;

/**
 * @uses Respect\Validation\Validator
 */
use Respect\Validation\Validator as v;

class Cartao
{
    /**
     * Número do cartão.
     *
     * @var integer
     */
    private $_cartao;
    
    /**
     * Bandeira do cartão
     *
     * vista ou mastercard (sempre minúsculo)
     *
     * @var string
     */
    private $_bandeira = 'visa';
    
    /**
     * Indicador do código de segurança:
     *
     * 0 (não informado)
     * 1 (informado)
     * 2 (ilegível)
     * 9 (inexistente)
     *
     * @var integer
     */
    private $_indicador = 0;
    /**
     * Código de segurança do cartão, obrigatório se o indicador for 1
     *
     * @var string
     */
    private $_codigoSeguranca;
    /**
     * Nome impresso no cartão.
     *
     * @var string
     */
    private $_nomePortador;
    /**
     * Validade do cartão no formato aaaamm.
     * Exemplos: 201212 (dez 2012).
     *
     * @var integer
     */
    private $_validade;
    
    /**
     * Retorna o número do cartão
     *
     * @access public
     * @return integer
     */
    public function getCartao()
    {
        return $this->_cartao;
    }

    /**
     * Configura o número do cartão
     *
     * @access public
     * @param  integer $cartao
     * @return Cielo
     */
    public function setCartao($cartao)
    {
        try {
            v::notEmpty()->creditCard()->check($cartao);
                
            $this->_cartao = filter_var($cartao, FILTER_SANITIZE_NUMBER_INT);

            return $this;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Retorna o indicador do código de segurança setado
     *
     * @access public
     * @return integer
     */
    public function getIndicador()
    {
        return $this->_indicador;
    }

    /**
     * Indicador do código de segurança:
     *
     * 0 (não informado)
     * 1 (informado)
     * 2 (ilegível)
     * 9 (inexistente)
     *
     * @var integer
     */
    public function setIndicador($_indicador)
    {
        switch ((integer) $_indicador) {
            case 0:
            case 1:
            case 2:
            case 9:
                $this->_indicador = (integer) substr($_indicador, 0, 1);

                return $this;
                break;
            default:
                throw new Exception('Indicador de segurança inválido.');
        }
    }

    /**
     * Retorna o código de segurança configurado para cartão
     *
     * @access public
     * @return string
     */
    public function getCodigoSeguranca()
    {
        return $this->_codigoSeguranca;
    }

    /**
     * Seta o código de segurança do cartão
     *
     * @access public
     * @param  string $_codigo
     * @return Cielo
     */
    public function setCodigoSeguranca($_codigo)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_codigo)) {
            throw new Exception('Código de segurança inválido.');
        } else {
            $this->_codigoSeguranca = filter_var($_codigo, FILTER_SANITIZE_STRING);

            return $this;
        }
    }

    /**
     * Retorna o nome do portador do cartão
     *
     * @access public
     * @return string
     */
    public function getNomePortador()
    {
        return $this->_nomePortador;
    }

    /**
     * Seta o nome do portador do cartão
     *
     * @access public
     * @param  string $_nomePortador
     * @return Cielo
     */
    public function setNomePortador($_nomePortador)
    {
        if (preg_match('/[[:alnum:]]/i', $_nomePortador)) {
            $this->_nomePortador = substr($_nomePortador, 0, 50);

            return $this;
        } else {
            throw new Exception('Caracteres inválidos no nome do portador.');
        }
    }

    /**
     * Retorna a data de validade setada para o cartão
     *
     * @access public
     * @return integer
     */
    public function getValidade()
    {
        return $this->_validade;
    }

    /**
     * Configura a data de validade do cartão
     *
     * @access public
     * @param  integer $_validade AAAAMM
     * @return Cielo
     */
    public function setValidade($_validade)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_validade)) {
            throw new Exception('Data de validade inválida.');
        }

        if (strlen($_validade) != 6) {
            throw new Exception('Data de validade inválida.');
        }

        if ($_validade < date('Ym')) {
            throw new Exception('Cartão com validade ultrapassada.');
        }

        $this->_validade = substr($_validade, 0, 6);

        return $this;
    }
    
    /**
     * Retorna a bandeira do cartão
     *
     * @access public
     * @return string
     */
    public function getBandeira()
    {
        return $this->_bandeira;
    }

    /**
     * Configura a bandeira do cartão
     *
     * @access public
     * @param  string $_bandeira
     * @return Cielo
     */
    public function setBandeira($_bandeira)
    {
        if (preg_match('/(visa|mastercard)/i', $_bandeira)) {
            $this->_bandeira = strtolower($_bandeira);

            return $this;
        } else {
            throw new Exception('Bandeira inválida.');
        }
    }
}