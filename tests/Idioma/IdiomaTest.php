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

use MrPrompt\Cielo\Idioma\Idioma;
use MrPrompt\Cielo\Idioma\Portugues;
use MrPrompt\Cielo\Idioma\Espanhol;
use MrPrompt\Cielo\Idioma\Ingles;
use PHPUnit\Framework\TestCase;

/**
 * Class IdiomaTest
 * @package MrPrompt\Cielo\Tests\Idioma
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class IdiomaTest extends TestCase
{
    /**
     * @var Idioma
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new class extends Idioma {
            /**
             * Recupera o idioma ativo
             * @return mixed
             */
            public function getIdioma()
            {
                return '';
            }
        };
    }

    /**
     * Data Provider
     * @return array
     */
    public function idiomasValidas(): array
    {
        return [
            [
                Portugues::IDIOMA
            ],
            [
                Espanhol::IDIOMA
            ],
            [
                Ingles::IDIOMA
            ],
        ];
    }

    /**
     * Data Provider
     * @return array
     */
    public function idiomasInvalidas(): array
    {
        return [
            [
                'fr'
            ],
            [
                ''
            ]
        ];
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Idioma\Idioma::valida()
     * @dataProvider idiomasValidas
     */
    public function validaDeveRetornarVerdadeiroParaUmaIdiomaValidaDoEndPoint($idioma): void
    {
        $result = $this->object->valida($idioma);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Idioma\Idioma::valida()
     * @dataProvider idiomasInvalidas
     */
    public function validaDeveRetornarFalsoParaUmaIdiomaInvalidaDoEndPoint($idioma): void
    {
        $result = $this->object->valida($idioma);

        $this->assertFalse($result);
    }
}
