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

namespace MrPrompt\Cielo\Tests\Ambiente;

use MrPrompt\Cielo\Ambiente\Ambiente;
use MrPrompt\Cielo\Ambiente\Producao;
use MrPrompt\Cielo\Ambiente\Teste;
use PHPUnit\Framework\TestCase;

/**
 * Class AmbienteTest
 * @package MrPrompt\Cielo\Tests\Ambiente
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class AmbienteTest extends TestCase
{
    /**
     * @var Ambiente
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
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
    public function urlsValidas(): array
    {
        return [
            [
                Producao::URL
            ],
            [
                Teste::URL
            ]
        ];
    }

    /**
     * Data Provider
     * @return array
     */
    public function urlsInvalidas(): array
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
     * @covers \MrPrompt\Cielo\Ambiente\Ambiente::validaUrl()
     * @dataProvider urlsValidas
     */
    public function validaUrlDeveRetornarVerdadeiroParaUmaUrlValidaDoEndPoint(string $url): void
    {
        $result = $this->object->validaUrl($url);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Ambiente\Ambiente::validaUrl()
     * @dataProvider urlsInvalidas
     */
    public function validaUrlDeveRetornarFalsoParaUmaUrlInvalidaDoEndPoint(string $url): void
    {
        $result = $this->object->validaUrl($url);

        $this->assertFalse($result);
    }
}
