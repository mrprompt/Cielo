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

namespace MrPrompt\Cielo\Tests;

use DateTime;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use MrPrompt\Cielo\Transacao;
use PHPUnit\Framework\TestCase;

/**
 * Class ClienteTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class ClienteTest extends TestCase
{
    /**
     * @var Cliente
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->object = new Cliente($mockAutorizacao);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::iniciaTransacao()
     */
    public function iniciaTransacaoDeveRetornarUmObjectSolicitacaoTransacao()
    {
        // @todo Tests broken with getDataHora, fix it.
        $this->markTestIncomplete();
        
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->setMethods(['getDataHora' => new DateTime])
                        ->disableOriginalConstructor()
                        ->getMock();

        $cartao = $this->getMockBuilder(Cartao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $url = 'http://localhost';

        $result = $this->object->iniciaTransacao($transacao, $cartao, $url);

        $this->assertInstanceOf(SolicitacaoTransacao::class, $result);
    }
}
