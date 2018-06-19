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
 * @package    MrPrompt\Cielo
 * @subpackage Token
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
 * Class Token
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class Token
{

    /**
     * Número do cartão truncado
     *
     * @SerializedName("dados-token")
     * @Type("MrPrompt\Cielo\Modelos\DadosToken")
     * @var \MrPrompt\Cielo\Modelos\DadosToken
     */
    private $dadosToken;

    /**
     * Construtor
     *
     */
    public function __construct()
    {
    }

    /**
     * @return DadosToken
     */
    public function getDadosToken()
    {
        return $this->dadosToken;
    }

    /**
     * @param DadosToken $dadosToken
     */
    public function setDadosToken($dadosToken)
    {
        $this->dadosToken = $dadosToken;
    }

}
