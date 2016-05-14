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
namespace MrPrompt\Cielo\Tests\Requisicao;

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Idioma;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;
use ReflectionMethod;
use MrPrompt\Cielo\Requisicao\AutorizacaoPortador;

class AutorizacaoPortadorTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var AutorizacaoPortador
     */
    protected $object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $mockAutorizacao = $this->getMock(Autorizacao::class, [], [], '', false);
        $mockCartao      = $this->getMock(Cartao::class, [], [], '', false);
        $idioma          = $this->getMock(Idioma::class, [], [], '', false);
        $mockTransacao   = $this->getMock(Transacao::class, [], [], '', false);
        $mockTransacao->method('getDataHora')->willReturn(new \DateTimeImmutable());

        $this->object 	 = new AutorizacaoPortador($mockAutorizacao, $mockTransacao, $mockCartao, $idioma);
    }
    
    /**
     * @test
     * 
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::getXmlInicial()
     */
    public function getXmlInicial()
    {
        $method = new ReflectionMethod($this->object, 'getXmlInicial');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNotEmpty($result);
    }
    
    /**
     * @test
     * 
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::configuraEnvio()
     */
    public function configuraEnvio()
    {
        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
    
    /**
     * @test
     * 
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaCartao()
     */
    public function adicionaCartao()
    {
        $method = new ReflectionMethod($this->object, 'adicionaCartao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
    
    /**
     * @test
     * 
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaTransacao()
     */
    public function adicionaTransacao()
    {
        $method = new ReflectionMethod($this->object, 'adicionaTransacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
    
    /**
     * @test
     * 
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento()
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
}