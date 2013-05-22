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
    private $cartao;

    /**
     * Bandeira do cartão
     *
     * vista ou mastercard (sempre minúsculo)
     *
     * @var string
     */
    private $bandeira = 'visa';

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
    private $indicador = 0;
    /**
     * Código de segurança do cartão, obrigatório se o indicador for 1
     *
     * @var string
     */
    private $codigoSeguranca;
    /**
     * Nome impresso no cartão.
     *
     * @var string
     */
    private $nomePortador;
    /**
     * Validade do cartão no formato aaaamm.
     * Exemplos: 201212 (dez 2012).
     *
     * @var integer
     */
    private $validade;

    /**
     * Retorna o número do cartão
     *
     * @access public
     * @return integer
     */
    public function getCartao()
    {
        return $this->cartao;
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

            $this->cartao = filter_var($cartao, FILTER_SANITIZE_NUMBER_INT);

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
        return $this->indicador;
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
    public function setIndicador($indicador)
    {
        switch ((integer) $indicador) {
            case 0:
            case 1:
            case 2:
            case 9:
                $this->indicador = (integer) substr($indicador, 0, 1);

                return $this;
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
        return $this->codigoSeguranca;
    }

    /**
     * Seta o código de segurança do cartão
     *
     * @access public
     * @param  string $codigo
     * @return Cielo
     */
    public function setCodigoSeguranca($codigo)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $codigo)) {
            throw new Exception('Código de segurança inválido.');
        }

        $this->codigoSeguranca = filter_var($codigo, FILTER_SANITIZE_STRING);

        return $this;
    }

    /**
     * Retorna o nome do portador do cartão
     *
     * @access public
     * @return string
     */
    public function getNomePortador()
    {
        return $this->nomePortador;
    }

    /**
     * Seta o nome do portador do cartão
     *
     * @access public
     * @param  string $nomePortador
     * @return Cielo
     */
    public function setNomePortador($nomePortador)
    {
        if (preg_match('/[[:alnum:]]/i', $nomePortador)) {
            $this->nomePortador = substr($nomePortador, 0, 50);

            return $this;
        }

        throw new Exception('Caracteres inválidos no nome do portador.');
    }

    /**
     * Retorna a data de validade setada para o cartão
     *
     * @access public
     * @return integer
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * Configura a data de validade do cartão
     *
     * @access public
     * @param  integer $validade AAAAMM
     * @return Cielo
     */
    public function setValidade($validade)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $validade)) {
            throw new Exception('Data de validade inválida.');
        }

        if (strlen($validade) != 6) {
            throw new Exception('Data de validade inválida.');
        }

        if ($validade < date('Ym')) {
            throw new Exception('Cartão com validade ultrapassada.');
        }

        $this->validade = substr($validade, 0, 6);

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
        return $this->bandeira;
    }

    /**
     * Configura a bandeira do cartão
     *
     * @access public
     * @param  string $bandeira
     * @return Cielo
     */
    public function setBandeira($bandeira)
    {
        if (preg_match('/(visa|mastercard)/i', $bandeira)) {
            $this->bandeira = strtolower($bandeira);

            return $this;
        }

        throw new Exception('Bandeira inválida.');
    }
}
