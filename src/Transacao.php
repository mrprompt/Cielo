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
declare(strict_types = 1);

namespace MrPrompt\Cielo;

use DateTime;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use InvalidArgumentException;

/**
 * Class Transacao
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Transacao
{
    const PARCELAS_MINIMAS = 1;
    const MOEDA_PADRAO     = 986;

    /**
     * TID da transação
     *
     * @Type("integer")
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
     * @Type("string")
     * @var string
     */
    private $produto = 1;

    /**
     * Número de parcelas da venda
     *
     * @Type("integer")
     * @var integer
     */
    private $parcelas = self::PARCELAS_MINIMAS;

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @Type("integer")
     * @var integer
     */
    private $moeda = self::MOEDA_PADRAO;

    /**
     * Define se a transação será automaticamente capturada caso
     * seja autorizada.
     *
     * @Type("string")
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
     * @Type("integer")
     * @var integer
     */
    private $autorizar = 0;

    /**
     * Data hora do pedido.
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @Type("DateTime")
     * @var datetime
     */
    private $dataHora;

    /**
     * Número do pedido da loja.
     *
     * @Type("integer")
     * @var integer
     */
    private $numeroPedido;

    /**
     * Valor do pedido
     *
     * @Type("integer")
     * @var integer
     */
    private $valorPedido;

    /**
     * Descricao da transação
     *
     * @Type("string")
     * @var string
     */
    private $descricao;

    /**
     * Gerar token para cartão do portador?
     *
     * @Type("boolean")
     * @var boolean
     */
    private $gerarToken = false;

    /**
     * Construtor
     *
     * @param DateTime $dataHora
     */
    public function __construct(DateTime $dataHora = null)
    {
        $this->dataHora = $dataHora ?: new DateTime();
    }

    /**
     * Configura o valor do TID
     *
     * @access public
     * @return string
     */
    public function getTid(): string
    {
        return (string) $this->tid;
    }

    /**
     * Configura o TID
     *
     * @access public
     * @param  string $tid
     * @return Transacao
     */
    public function setTid(string $tid): Transacao
    {
        if (!v::notEmpty()->validate($tid)) {
            throw new InvalidArgumentException('Caracteres inválidos no TID.');
        }

        $this->tid = $tid;

        return $this;
    }

    /**
     * Retorna o tipo de compra/produto
     *
     * @access public
     * @return string
     */
    public function getProduto(): string
    {
        return (string) $this->produto;
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
     * @return Transacao
     */
    public function setProduto(string $produto): Transacao
    {
        if (!v::in(['1', '2', '3', 'A'])->validate($produto)) {
            throw new InvalidArgumentException('Tipo de produto inválido.');
        }

        $this->produto = $produto;

        return $this;
    }

    /**
     * Retorna o número de parcelas
     *
     * @access public
     * @return integer
     */
    public function getParcelas(): int
    {
        return (int) $this->parcelas;
    }

    /**
     * Configura o número de parcelas da venda
     *
     * @access public
     * @param  integer $parcelas
     * @return Transacao
     */
    public function setParcelas(int $parcelas = self::PARCELAS_MINIMAS): Transacao
    {
        if (!v::digit()->notEmpty()->min(self::PARCELAS_MINIMAS, self::PARCELAS_MINIMAS)->validate($parcelas)) {
            throw new InvalidArgumentException('Número de parcelas inválido.');
        }

        $this->parcelas = (integer) $parcelas;

        return $this;
    }

    /**
     * Retorna o tipo de moeda utilizado na venda
     *
     * @access public
     * @return integer
     */
    public function getMoeda(): int
    {
        return (int) $this->moeda;
    }

    /**
     * Código numérico da moeda na ISO 4217 (R$ é 986 - default)
     *
     * @access public
     * @param  integer $moeda
     * @return Transacao
     */
    public function setMoeda(int $moeda = self::MOEDA_PADRAO): Transacao
    {
        $this->moeda = $moeda;

        return $this;
    }

    /**
     * Retorna se é ou não para capturar automaticamente a venda
     *
     * @access public
     * @return bool
     */
    public function getCapturar()
    {
        return (bool) $this->capturar;
    }

    /**
     * Informa se é para capturar automaticamente a venda
     *
     * @access public
     * @param  bool $capturar
     * @return Transacao
     */
    public function setCapturar(bool $capturar = false): Transacao
    {
        $this->capturar = $capturar;

        return $this;
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
    public function getAutorizar(): int
    {
        return (int) $this->autorizar;
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
     * @return Transacao
     */
    public function setAutorizar(int $autorizar = 0): Transacao
    {
        $this->autorizar = $autorizar;

        return $this;
    }

    /**
     * Retorna a data e hora configurada para a transação
     *
     * @access public
     * @return \DateTime
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * Seta a data e hora da venda
     *
     * @access public
     * @param  DateTime $dataHora
     * @return Transacao
     */
    public function setDataHora(DateTime $dataHora): Transacao
    {
        $this->dataHora = $dataHora;

        return $this;
    }

    /**
     * Retorna o número do pedido
     *
     * @access public
     * @return integer
     */
    public function getNumero(): int
    {
        return (int) $this->numeroPedido;
    }

    /**
     * Configura o número do pedido
     *
     * @access public
     * @param  integer $numero
     * @return Transacao
     */
    public function setNumero(int $numero): Transacao
    {
        $this->numeroPedido = (int) substr((string) $numero, 0, 50);

        return $this;
    }

    /**
     * Retorna o valo da venda
     *
     * @access public
     * @return integer
     */
    public function getValor(): int
    {
        return (int) $this->valorPedido;
    }

    /**
     * Configura o valor da venda
     *
     * O valor da venda é um inteiro sem separador, onde os dois últimos
     * digitos referem-se aos centavos. Ex.: 1237 = R$ 12,37
     *
     * @access public
     * @param  int $valor
     * @return Transacao
     */
    public function setValor(int $valor): Transacao
    {
        $this->valorPedido = $valor;

        return $this;
    }

    /**
     * Informa a descrição da operação
     *
     * @access public
     * @param  string $descricao
     * @return Transacao
     */
    public function setDescricao(string $descricao): Transacao
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
    public function getDescricao(): string
    {
        return (string) $this->descricao;
    }

    /**
     * Indica se é para gerar token para o cartão do portador.
     * @return boolean
     */
    public function isGerarToken(): bool
    {
        return (bool) $this->gerarToken;
    }

    /**
     * Define se é para gerar token para o cartão do portador.
     *
     * @param boolean $gerarToken
     * @return Transacao
     */
    public function setGerarToken(bool $gerarToken = true): Transacao
    {
        $this->gerarToken = $gerarToken;

        return $this;
    }
}
