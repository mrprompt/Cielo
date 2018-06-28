<?php
/**
 * DadosPedido
 *
 * Dados do Pedido.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage DadosPedido
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);


namespace MrPrompt\Cielo\Modelos;

use DateTime;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use InvalidArgumentException;

/**
 * Class DadosPedido
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class DadosPedido
{
    /**
     * @Type("integer")
     * @var integer
     */
    private $numero;

    /**
     * @Type("integer")
     * @var integer
     */
    private $valor;

    /**
     * @Type("integer")
     * @var integer
     */
    private $moeda;

    /**
     * Data hora do pedido.
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @SerializedName("data-hora")
     * @Type("string")
     * @var datetime
     */
    private $dataHora;

    /**
     * @Type("string")
     * @var string
     */
    private $descricao;

    /**
     * @Type("string")
     * @var string
     */
    private $idioma;

    /**
     * Construtor
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return int
     */
    public function getMoeda()
    {
        return $this->moeda;
    }

    /**
     * @param int $moeda
     */
    public function setMoeda($moeda)
    {
        $this->moeda = $moeda;
    }

    /**
     * @return DateTime
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * @param DateTime $dataHoraString
     */
    public function setDataHora( $dataHoraString )
    {
        $dateFormated = DateTime::createFromFormat( 'Y-m-d\TH:i:s', $dataHoraString );

        $this->dataHora = $dateFormated;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return string
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * @param string $idioma
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
    }
}
