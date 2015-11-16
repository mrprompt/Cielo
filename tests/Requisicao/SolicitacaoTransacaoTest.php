<?php
namespace MrPrompt\Cielo\Tests\Requisicao;

use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use ReflectionMethod;

class SolicitacaoTransacaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var SolicitacaoTransacao
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
        $urlRetorno      = 'http://localhost/';
        $idioma          = 'PT';

        $this->object = new SolicitacaoTransacao(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $urlRetorno,
            $idioma
        );
    }
  
  	/**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @expectedException \InvalidArgumentException
     */
  	public function construtorDisparaExcessaoComUrlDeRetornoInvalida()
    {
        $mockAutorizacao = $this->getMock('MrPrompt\Cielo\Autorizacao', array(), array(), '', false);
        $mockTransacao   = $this->getMock('MrPrompt\Cielo\Transacao', array(), array(), '', false);
        $mockCartao      = $this->getMock('MrPrompt\Cielo\Cartao', array(), array(), '', false);
        $urlRetorno      = 'http:///';
        $idioma          = 'PT';

        $this->object = new SolicitacaoTransacao(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $urlRetorno,
            $idioma
        );
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     */
    public function configuraEnvio()
    {
        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::deveAdicionarTid()
     */
    public function deveAdicionarTid()
    {
        $method = new ReflectionMethod($this->object, 'deveAdicionarTid');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaPortador()
     */
    public function adicionaPortador()
    {
        $method = new ReflectionMethod($this->object, 'adicionaPortador');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaTransacao()
     */
    public function adicionaTransacao()
    {
        $method = new ReflectionMethod($this->object, 'adicionaTransacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento()
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}