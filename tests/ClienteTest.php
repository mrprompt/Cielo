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
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Autorizacao;
use PHPUnit\Framework\TestCase;
use MrPrompt\Cielo\Requisicao\Requisicao;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;

/**
 * Class ClienteTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class ClienteTest extends TestCase
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
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::iniciaTransacao()
     */
    public function iniciaTransacaoDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $cartao = $this->getMockBuilder(Cartao::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $cartao->method('getCodigoSeguranca')->willReturn(123);
        
        $url = 'http://localhost';

        $result = $this->object->iniciaTransacao($transacao, $cartao, $url);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::solicitaToken()
     */
    public function solicitaTokenDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $cartao = $this->getMockBuilder(Cartao::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $cartao->method('getCodigoSeguranca')->willReturn(123);
        
        $result = $this->object->solicitaToken($transacao, $cartao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::autoriza()
     */
    public function autorizaDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $result = $this->object->autoriza($transacao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::captura()
     */
    public function capturaDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $result = $this->object->captura($transacao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::cancela()
     */
    public function cancelaDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $result = $this->object->cancela($transacao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::consulta()
     */
    public function consultaDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $result = $this->object->consulta($transacao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::tid()
     */
    public function tidDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $cartao = $this->getMockBuilder(Cartao::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $cartao->method('getCodigoSeguranca')->willReturn(123);

        $result = $this->object->tid($transacao, $cartao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::autorizaPortador()
     */
    public function autorizaPortadorDeveRetornarUmXmlValido()
    {
        $transacao = $this->getMockBuilder(Transacao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $cartao = $this->getMockBuilder(Cartao::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $cartao->method('getCodigoSeguranca')->willReturn(123);

        $result = $this->object->autorizaPortador($transacao, $cartao);

        $this->assertNotEmpty($result);
        $this->assertTrue(is_object($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::__construct()
     * @covers \MrPrompt\Cielo\Cliente::enviaRequisicao()
     */
    public function enviaRequisicaoDeveRetornarUmXmlValido()
    {
        $xml = simplexml_load_string('<foo></foo>');
        $requisicao = $this->getMockBuilder(Requisicao::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        
        $requisicao->method('getEnvio')->willReturn($xml);
        $requisicao->method('setResposta')->willReturn(null);
        $requisicao->method('getResposta')->willReturn($xml->asXML());

        $class = new \ReflectionClass($this->object);
        $method = $class->getMethod('enviaRequisicao');
        $method->setAccessible(true);
        
        $result = $method->invokeArgs($this->object, [$requisicao]);

        $this->assertNotEmpty($result);
    }
}
