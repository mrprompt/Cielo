<?php
/**
 * Cielo
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Retorno
 * @subpackage Erro
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Tid
{
    /**
     * @Type("string")
     * @var string
     */
    public $tid;
}
