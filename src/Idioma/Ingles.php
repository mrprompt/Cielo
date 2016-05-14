<?php
/**
 * Cliente
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de crédito de várias
 * bandeiras, homologadas pela Cielo.
 * Com a integração, é possível efetuar vendas através do crédito ou
 * débito, em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo
 * @subpackage Cliente
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types = 1);

namespace MrPrompt\Cielo\Idioma;

use MrPrompt\Cielo\Idioma;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Ingles extends Idioma
{
    /**
     * @const string
     */
    const IDIOMA = 'EN';

    /**
     * @inheritdoc
     */
    public function getIdioma(): string
    {
        return static::IDIOMA;
    }

}