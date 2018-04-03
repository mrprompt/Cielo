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
 * @package    MrPrompt\Cielo\Tests
 * @subpackage Cliente
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types=1);

namespace MrPrompt\Cielo\Tests\Idioma;

use MrPrompt\Cielo\Idioma\Ingles;
use PHPUnit\Framework\TestCase;

/**
 * Class InglesTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class InglesTest extends TestCase
{
    /**
     * @var Ingles
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Ingles();
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Idioma\Ingles::getIdioma()
     */
    public function getIdiomaDeveRetornarValorDaConstante(): void
    {
        $result = $this->object->getIdioma();

        $this->assertEquals(Ingles::IDIOMA, $result);
    }
}
