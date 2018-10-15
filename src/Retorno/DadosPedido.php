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
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage DadosPedido
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use MrPrompt\Cielo\Retorno\Traits\GetterSetter;

/**
 * Class DadosPedido
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class DadosPedido
{
    use GetterSetter;
    
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
     * @var string
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
}
