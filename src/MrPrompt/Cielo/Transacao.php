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

use InvalidArgumentException;

class Transacao
{
    /**
     * TID da transação
     *
     * @var integer
     */
    private $tid;

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
    private $produto = 1;

    /**
     * Número de parcelas da venda
     *
     * @var integer
     */
    private $parcelas = 1;

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @var integer
     */
    private $moeda = 986;

    /**
     * Define se a transação será automaticamente capturada caso
     * seja autorizada.
     *
     * @var string
     */
    private $capturar = 'false';

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
    private $autorizar = 0;

    /**
     * Data hora do pedido.
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @var datetime
     */
    private $dataHora;

    /**
     * Número do pedido da loja.
     *
     * @var integer
     */
    private $numeroPedido;

    /**
     * Valor do pedido
     *
     * @var integer
     */
    private $valorPedido;

    /**
     * Descricao da transação
     *
     * @var string
     */
    private $descricao;

    /**
     * Configura o valor do TID
     *
     * @access public
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * Configura o TID
     *
     * @access public
     * @param  string $tid
     * @return Cielo
     */
    public function setTid($tid)
    {
        $this->tid = $tid;

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
        return $this->produto;
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
     * @param  mixed $produto
     * @return Cielo
     */
    public function setProduto($produto)
    {
        switch ($produto) {
            case '1':
            case '2':
            case '3':
            case 'A':
                $this->produto = $produto;

                return $this;
            default:
                throw new InvalidArgumentException('Tipo de produto inválido.');
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
        return $this->parcelas;
    }

    /**
     * Configura o número de parcelas da venda
     *
     * @access public
     * @param  integer $parcelas
     * @return Cielo
     */
    public function setParcelas($parcelas)
    {
        $this->parcelas = (integer) $parcelas;

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
        return $this->moeda;
    }

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @access public
     * @param  integer $moeda
     * @return Cielo
     */
    public function setMoeda($moeda = 986)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $moeda)) {
            throw new InvalidArgumentException('Moeda inválida');
        }

        $this->moeda = (integer) substr($moeda, 0, 3);

        return $this;
    }

    /**
     * Retorna se é ou não para capturar automaticamente a venda
     *
     * @access public
     * @return string
     */
    public function getCapturar()
    {
        return $this->capturar;
    }

    /**
     * Informa se é para capturar automaticamente a venda
     *
     * @access public
     * @param  string $capturar
     * @return Cielo
     */
    public function setCapturar($capturar)
    {
        switch ($capturar) {
            case 'true':
            case 'false':
                $this->capturar = $capturar;

                return $this;
            default:
                throw new InvalidArgumentException('Parâmetro inválido.');
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
        return $this->autorizar;
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
     * @param  integer $autorizar
     * @return integer
     */
    public function setAutorizar($autorizar)
    {
        switch ((integer) $autorizar) {
            case 0:
            case 1:
            case 2:
            case 3:
                $this->autorizar = (integer) $autorizar;

                return $this;
            default:
                throw new InvalidArgumentException('Indicador de autorização inválido.');
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
        return $this->dataHora;
    }

    /**
     * Seta a data e hora da venda
     *
     * @access public
     * @param  datetime $dataHora AAAA-MM-DDTHH:MM:SS
     * @return Cielo
     */
    public function setDataHora($dataHora)
    {
        if (strlen($dataHora) !== 19) {
            throw new InvalidArgumentException('Formato inválido.');
        }

        $this->dataHora = $dataHora;

        return $this;
    }

    /**
     * Retorna o número do pedido
     *
     * @access public
     * @return integer
     */
    public function getNumero()
    {
        return $this->numeroPedido;
    }

    /**
     * Configura o número do pedido
     *
     * @access public
     * @param  integer $numero
     * @return Cielo
     */
    public function setNumero($numero)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $numero)) {
            throw new InvalidArgumentException('Número do pedido inválido.');
        }

        $this->numeroPedido = substr($numero, 0, 50);

        return $this;
    }

    /**
     * Retorna o valo da venda
     *
     * @access public
     * @return integer
     */
    public function getValor()
    {
        return $this->valorPedido;
    }

    /**
     * Configura o valor da venda
     *
     * O valor da venda é um inteiro sem separador, onde os dois últimos
     * digitos referem-se aos centavos. Ex.: 1200 = R$ 12,00
     *
     * @access public
     * @param  integer $valor
     * @return Cielo
     */
    public function setValor($valor)
    {
        if (preg_match('/([[:alpha:]]|[[:punct:]]|[[:space:]])/', $valor)) {
            throw new InvalidArgumentException('Valor inválido.');
        }

        $valor = number_format ( (float) $valor, 2, '' , '' );

        $this->valorPedido = substr($valor, 0, 12);

        return $this;
    }

    /**
     * Informa a descrição da operação
     *
     * @access public
     * @param  string $descricao
     * @return Cielo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

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
        return $this->descricao;
    }
}
