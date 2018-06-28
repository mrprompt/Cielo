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
     * @SerializedName("data-hora")
     * @Type("string")
     * @var string
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
     * @return string
     */
    public function getDataHora(): string
    {
        return $this->dataHora;
    }

    /**
     * @param string $dataHora
     */
    public function setDataHora(string $dataHora): void
    {
        $this->dataHora = $dataHora;
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
