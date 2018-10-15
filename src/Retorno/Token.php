<?php
/**
 * Token
 *
 * Dados do Token.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage Token
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use DateTime;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class Token
 * 
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Token
{
    use GetterSetter;

    /**
     * Número do cartão truncado
     *
     * @SerializedName("dados-token")
     * @Type("MrPrompt\Cielo\Retorno\DadosToken")
     * @var \MrPrompt\Cielo\Retorno\DadosToken
     */
    private $dadosToken;
}
