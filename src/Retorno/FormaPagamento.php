<?php
/**
 * Modelo
 *
 * Informações da forma de pagamento
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage FormaPagamento
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2010
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use MrPrompt\Cielo\Retorno\Traits\GetterSetter;

/**
 * Class FormaPagamento
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Felipe Araujo <felipearaujo.asti@gmail.com>
 */
class FormaPagamento
{
    use GetterSetter;
    
    /**
     * @Type("string")
     * @var string
     */
    private $bandeira;

    /**
     * @Type("string")
     * @var string
     */
    private $produto;

    /**
     * @Type("integer")
     * @var integer
     */
    private $parcelas;
}
