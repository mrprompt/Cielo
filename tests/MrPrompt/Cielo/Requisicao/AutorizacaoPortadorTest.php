<?php
namespace MrPrompt\Cielo\Requisicao;

use ReflectionMethod;

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
        $mockAutorizacao = $this->getMock('MrPrompt\Cielo\Autorizacao', array(), array(), '', false);
        $mockTransacao   = $this->getMock('MrPrompt\Cielo\Transacao', array(), array(), '', false);
        $mockCartao      = $this->getMock('MrPrompt\Cielo\Cartao', array(), array(), '', false);
        $idioma          = 'PT';
        
        $this->object 	 = new AutorizacaoPortador(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $idioma
        );
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