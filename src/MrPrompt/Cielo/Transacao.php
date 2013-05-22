<?php
/**
 * Transacao
 * 
 * Transação a ser utilizada pelo cliente.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Transacao
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
namespace MrPrompt\Cielo;

/**
 * @uses \MrPrompt\Cielo\Transacao\Exception
 */
use MrPrompt\Cielo\Transacao\Exception;

class Transacao
{
    /**
     * TID da transação
     *
     * @var integer
     */
    private $_tid;
    
    /**
     * Tipo de compra
     *
     * Código do produto:
     * 1 (Crédito à Vista)
     * 2 (Parcelado loja)
     * 3 (Parcelado administradora)
     * A (Débito)
     *
     * @var string
     */
    private $_produto = 1;

    /**
     * Número de parcelas da venda
     *
     * @var integer
     */
    private $_parcelas = 1;

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @var integer
     */
    private $_moeda = 986;
    
    /**
     * Define se a transação será automaticamente capturada caso
     * seja autorizada.
     *
     * @var string
     */
    private $_capturar = 'false';
    
    /**
     * Indicador de autorização automática:
     *
     * 0 (não autorizar)
     * 1 (autorizar somente se autenticada)
     * 2 (autorizar autenticada e não-autenticada)
     * 3 (autorizar sem passar por autenticação – válido somente para crédito)
     *
     * @var integer
     */
    private $_autorizar = 0;
    
    /**
     * Data hora do pedido.
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @var datetime
     */
    private $_dataHora;
    
    /**
     * Número do pedido da loja.
     *
     * @var integer
     */
    private $_numeroPedido;
    
    /**
     * Valor do pedido
     *
     * @var integer
     */
    private $_valorPedido;

    /**
     * Descricao da transação
     *
     * @var string 
     */
    private $_descricao;
    
    /**
     * Configura o valor do TID
     *
     * @access public
     * @return string
     */
    public function getTid()
    {
        return $this->_tid;
    }

    /**
     * Configura o TID
     *
     * @access public
     * @param  string $_tid
     * @return Cielo
     */
    public function setTid($_tid)
    {
        $this->_tid = $_tid;

        return $this;
    }
    
    /**
     * Retorna o tipo de compra/produto
     *
     * @access public
     * @return integer
     */
    public function getProduto()
    {
        return $this->_produto;
    }

    /**
     * Configura o Tipo de compra/produto
     *
     * Código do produto:
     * 1 (Crédito à Vista)
     * 2 (Parcelado loja)
     * 3 (Parcelado administradora)
     * A (Débito)
     *
     * @access public
     * @param  mixed $_produto
     * @return Cielo
     */
    public function setProduto($_produto)
    {
        switch ($_produto) {
            case '1':
            case '2':
            case '3':
            case 'A':
                $this->_produto = $_produto;

                return $this;
            default:
                throw new Exception('Tipo de produto inválido.');
                break;
        }
    }

    /**
     * Retorna o número de parcelas
     *
     * @access public
     * @return integer
     */
    public function getParcelas()
    {
        return $this->_parcelas;
    }

    /**
     * Configura o número de parcelas da venda
     *
     * @access public
     * @param  integer $_parcelas
     * @return Cielo
     */
    public function setParcelas($_parcelas)
    {
        $this->_parcelas = (integer) $_parcelas;

        return $this;
    }

    /**
     * Retorna o tipo de moeda utilizado na venda
     *
     * @access public
     * @return integer
     */
    public function getMoeda()
    {
        return $this->_moeda;
    }

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @access public
     * @param  integer $_moeda
     * @return Cielo
     */
    public function setMoeda($_moeda = 986)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_moeda)) {
            throw new Exception('Moeda inválida');
        } else {
            $this->_moeda = (integer) substr($_moeda, 0, 3);

            return $this;
        }
    }
    
    /**
     * Retorna se é ou não para capturar automaticamente a venda
     *
     * @access public
     * @return string
     */
    public function getCapturar()
    {
        return $this->_capturar;
    }

    /**
     * Informa se é para capturar automaticamente a venda
     *
     * @access public
     * @param  string $_capturar
     * @return Cielo
     */
    public function setCapturar($_capturar)
    {
        switch ($_capturar) {
            case 'true':
            case 'false':
                $this->_capturar = $_capturar;

                return $this;
                break;
            default:
                throw new Exception('Parâmetro inválido.');
        }
    }

    /**
     * Retorna o Indicador de autorização automática:
     *
     * 0 (não autorizar)
     * 1 (autorizar somente se autenticada)
     * 2 (autorizar autenticada e não-autenticada)
     * 3 (autorizar sem passar por autenticação – válido somente para crédito)
     *
     * @access public
     * @return integer
     */
    public function getAutorizar()
    {
        return $this->_autorizar;
    }

    /**
     * Seta o Indicador de autorização automática:
     *
     * 0 (não autorizar)
     * 1 (autorizar somente se autenticada)
     * 2 (autorizar autenticada e não-autenticada)
     * 3 (autorizar sem passar por autenticação – válido somente para crédito)
     *
     * @access public
     * @param  integer $_autorizar
     * @return integer
     */
    public function setAutorizar($_autorizar)
    {
        switch ((integer) $_autorizar) {
            case 0:
            case 1:
            case 2:
            case 3:
                $this->_autorizar = (integer) $_autorizar;

                return $this;
            default:
                throw new Exception('Indicador de autorização inválido.');
        }
    }

    /**
     * Retorna a data e hora configurada para a transação
     *
     * @access public
     * @return datetime
     */
    public function getDataHora()
    {
        return $this->_dataHora;
    }

    /**
     * Seta a data e hora da venda
     *
     * @access public
     * @param datetime $_dataHora AAAA-MM-DDTHH:MM:SS
     * @return Cielo
     */
    public function setDataHora($_dataHora)
    {
        if (strlen($_dataHora) !== 19) {
            throw new Exception('Formato inválido.');
        } else {
            $this->_dataHora = $_dataHora;

            return $this;
        }
    }

    /**
     * Retorna o número do pedido
     *
     * @access public
     * @return integer
     */
    public function getNumero()
    {
        return $this->_numeroPedido;
    }

    /**
     * Configura o número do pedido
     *
     * @access public
     * @param  integer $_numero
     * @return Cielo
     */
    public function setNumero($_numero)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_numero)) {
            throw new Exception('Número do pedido inválido.');
        } else {
            $this->_numeroPedido = substr($_numero, 0, 50);

            return $this;
        }
    }

    /**
     * Retorna o valo da venda
     *
     * @access public
     * @return integer
     */
    public function getValor()
    {
        return $this->_valorPedido;
    }

    /**
     * Configura o valor da venda
     *
     * O valor da venda é um inteiro sem separador, onde os dois últimos
     * digitos referem-se aos centavos. Ex.: 1200 = R$ 12,00
     *
     * @access public
     * @param  integer $_valor
     * @return Cielo
     */
    public function setValor($_valor)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $_valor)) {
            throw new Exception('Valor inválido.');
        } else {
            $this->_valorPedido = substr($_valor, 0, 12);

            return $this;
        }
    }

    /**
     * Informa a descrição da operação
     *
     * @access public
     * @param  string $_descricao
     * @return Cielo 
     */
    public function setDescricao($_descricao)
    {
        $this->_descricao = $_descricao;
        
        return $this;
    }
    
    /**
     * Retorna a descrição configurada para a transação
     *
     * @access public
     * @return string 
     */
    public function getDescricao()
    {
        return $this->_descricao;
    }
}