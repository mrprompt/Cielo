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
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage Autenticacao
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use MrPrompt\Cielo\Retorno\Traits\GetterSetter;

/**
 * Class Autenticacao
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Autenticacao
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
}
