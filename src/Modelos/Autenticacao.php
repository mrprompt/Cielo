<?php
/**
 * Autenticacao
 *
 * Dados da Autenticacao.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Autenticacao
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
 * Class Autenticacao
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Autenticacao
{
    /**
     * @Type("integer")
     * @var integer
     */
    private $codigo;

    /**
     * @Type("string")
     * @var string
     */
    private $mensagem;

    /**
     * Data Autenticacao
     *
     * Formato: AAAA-MM-DDTHH:MM:SS
     *
     * @SerializedName("data-hora")
     * @Type("string")
     * @var datetime
     */
    private $dataHora;


    /**
     * @Type("integer")
     * @var integer
     */
    private $valor;

    /**
     * @Type("integer")
     * @var integer
     */
    private $eci;

    /**
     * Construtor
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
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
        $dateFormated = DateTime::createFromFormat( $dataHoraString, 'Y-m-d\TH:i:s' );

        $this->dataHora = $dateFormated;
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
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * @param int $eci
     */
    public function setEci($eci)
    {
        $this->eci = $eci;
    }
}
