<?php
/**
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage DadosToken
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Modelos;

use DateTime;
use JMS\Serializer\Annotation as Serializer;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use InvalidArgumentException;

/**
 * Class DadosToken
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class DadosToken
{
    /**
     * codigo-token
     *
     * @SerializedName("codigo-token")
     * @Type("string")
     * @var string
     */
    private $codigoToken;

    /**
     * Status
     *
     * @Type("integer")
     * @var integer
     */
    private $status;

    /**
     * Número do cartão truncado
     *
     * @SerializedName("numero-cartao-truncado")
     * @Type("string")
     * @var string
     */
    private $numeroCartaoTruncado;

    /**
     * Construtor
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getCodigoToken()
    {
        return $this->codigoToken;
    }

    /**
     * @param string $codigoToken
     */
    public function setCodigoToken($codigoToken)
    {
        $this->codigoToken = $codigoToken;
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
     * @return string
     */
    public function getNumeroCartaoTruncado()
    {
        return $this->numeroCartaoTruncado;
    }

    /**
     * @param string $numeroCartaoTruncado
     */
    public function setNumeroCartaoTruncado($numeroCartaoTruncado)
    {
        $this->numeroCartaoTruncado = $numeroCartaoTruncado;
    }

}
