<?php
/**
 * Autorizacao
 *
 * Dados de Autorizacao.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage Autorizacao
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use MrPrompt\Cielo\Retorno\Traits\GetterSetter;

/**
 * Class Autorizacao
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Autorizacao
{
    use GetterSetter;
    
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
     * Data Autorizacao
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
     * @SerializedName("lr")
     * @Type("integer")
     * @var integer
     */
    private $lrCod;

    /**
     * @Type("integer")
     * @var integer
     */
    private $arp;

    /**
     * @Type("integer")
     * @var integer
     */
    private $nsu;
}
