<?php
namespace MrPrompt\Cielo\Requisicao;

use ReflectionMethod;

class IdentificacaoTransacaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var IdentificacaoTransacao
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
        
        $this->object = new IdentificacaoTransacao(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao
        );
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::configuraEnvio()
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
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::deveAdicionarTid()
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
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento()
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}