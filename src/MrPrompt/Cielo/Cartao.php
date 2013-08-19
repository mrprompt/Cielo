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

use Respect\Validation\Validator as v;
use InvalidArgumentException;

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
     * sempre minúsculo
     *
     * @var string
     */
    private $bandeira;

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
     * Token que liga o cartão ao estabelecimento
     *
     * @var string
     */
    private $token = null;

    /**
     * Bandeiras válidas
     *
     * @var array
     */
    private $bandeiras = array(
        'visa',
        'mastercard',
        'diners',
        'discover',
        'elo',
        'amex',
        'jcb',
        'aura',
    );

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
     * @param  string $cartao
     * @return Cartao
     */
    public function setCartao($cartao)
    {
        if (!v::notEmpty()->creditCard()->validate($cartao)) {
            throw new InvalidArgumentException('O número do cartão deve ser válido.');
        }

        $this->cartao = filter_var($cartao, FILTER_SANITIZE_NUMBER_INT);

        return $this;
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
     * @return Cartao
     */
    public function setIndicador($indicador)
    {
        if (!v::in(array(0, 1, 2, 9), true)->validate($indicador)) {
            throw new InvalidArgumentException('Indicador de código de segurança inválido.');
        }

        $this->indicador = (int) $indicador;

        return $this;
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
     * @return Cartao
     */
    public function setCodigoSeguranca($codigo)
    {
        if (!v::digit()->notEmpty()->noWhitespace()->validate($codigo)) {
            throw new InvalidArgumentException('Código de segurança inválido.');
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
     * @return Cartao
     */
    public function setNomePortador($nomePortador)
    {
        if (!v::alnum()->notEmpty()->validate($nomePortador)) {
            throw new InvalidArgumentException('Caracteres inválidos no nome do portador.');
        }

        $this->nomePortador = substr($nomePortador, 0, 50);

        return $this;
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
     * @param  integer $validade   AAAAMM
     * @param  integer $referencia
     * @return Cartao
     */
    public function setValidade($validade, $referencia = null)
    {
        if (!v::digit()->notEmpty()->noWhitespace()->length(6)->validate($validade)) {
            throw new InvalidArgumentException('Data de validade inválida.');
        }

        $referencia = $referencia ?: date('Ym');

        if ($validade < $referencia) {
            throw new InvalidArgumentException('Cartão com validade ultrapassada.');
        }

        $this->validade = $validade;

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
     * Obs.: A bandeira do cartão aceita somente caracteres minúsculos.
     *
     * @access public
     * @param  string $bandeira
     * @return Cartao
     */
    public function setBandeira($bandeira)
    {
        $regras = v::string()->notEmpty()
                             ->in($this->bandeiras)
                             ->lowercase()
                             ->alnum();
        
        if (!$regras->validate($bandeira)) {
            throw new InvalidArgumentException('Bandeira inválida.');
        }

        $this->bandeira = $bandeira;

        return $this;
    }
    
    /**
     * Recupera as bandeiras permitidas.
     * 
     * @return array
     */
    public function getBandeiras()
    {
        return $this->bandeiras;
    }

    /**
     * Recupera o token.
     * 
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }    

    /**
     * Configura o token.
     * 
     * @return string
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $token;
    }

    /**
     * Verifica se o token está configurado.
     * 
     * @return boolean
     */
    public function hasToken()
    {
        return ! empty($this->token);
    }

}