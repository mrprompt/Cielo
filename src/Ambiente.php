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

namespace MrPrompt\Cielo;

use MrPrompt\Cielo\Ambiente\Producao;
use MrPrompt\Cielo\Ambiente\Teste;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class Ambiente
{
    /**
     * Valida o endpoint
     * @param $url
     * @return bool
     */
    public function validaUrl($url): bool
    {
        return in_array($url, [Teste::URL, Producao::URL]);
    }

    /**
     * End-point do ambiente
     * @return string
     */
    abstract function getUrl(): string;
}