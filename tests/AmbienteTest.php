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
namespace MrPrompt\Cielo\Tests;

use MrPrompt\Cielo\Ambiente;

/**
 * Class AmbienteTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class AmbienteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Ambiente
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new class extends Ambiente {
            /**
             * End-point do ambiente
             * @return string
             */
            function getUrl(): string
            {
                return '';
            }
        };
    }

    /**
     * Data Provider
     * @return array
     */
    public function urlsValidas()
    {
        return [
            [
                Ambiente\Producao::URL
            ],
            [
                Ambiente\Teste::URL
            ]
        ];
    }

    /**
     * Data Provider
     * @return array
     */
    public function urlsInvalidas()
    {
        return [
            [
                'http://localhost'
            ],
            [
                ''
            ]
        ];
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Ambiente::validaUrl()
     * @dataProvider urlsValidas
     */
    public function validaUrlDeveRetornarVerdadeiroParaUmaUrlValidaDoEndPoint($url)
    {
        $result = $this->object->validaUrl($url);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Ambiente::validaUrl()
     * @dataProvider urlsInvalidas
     */
    public function validaUrlDeveRetornarFalsoParaUmaUrlInvalidaDoEndPoint($url)
    {
        $result = $this->object->validaUrl($url);

        $this->assertFalse($result);
    }
}
