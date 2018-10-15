<?php
/**
 * Modelo
 *
 * Seta informações token.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage DadosToken
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use MrPrompt\Cielo\Retorno\Traits\GetterSetter;

/**
 * Class DadosToken
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class DadosToken
{
    use GetterSetter;
    
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
}
