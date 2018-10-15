<?php
/**
 * Captura
 *
 * Dados do Captura.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage Captura
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class Captura
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Captura
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
     * Data captura
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
}
