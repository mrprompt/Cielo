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
namespace MrPrompt\Cielo;

use MrPrompt\Cielo\Idioma\Espanhol;
use MrPrompt\Cielo\Idioma\Ingles;
use MrPrompt\Cielo\Idioma\Portugues;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class Idioma
{
    /**
     * Valida idioma
     *
     * @param $idioma
     * @return bool
     */
    public function valida($idioma)
    {
        return in_array($idioma, [Espanhol::IDIOMA, Portugues::IDIOMA, Ingles::IDIOMA]);
    }

    /**
     * Recupera o idioma ativo
     * @return mixed
     */
    abstract public function getIdioma();
}