<?php
namespace MrPrompt\Cielo\Requisicao;

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
        
        $this->object = new AutorizacaoPortador(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $idioma
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\AutorizacaoPortador::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\AutorizacaoPortador::configuraEnvio()
     * @todo   Implement configuraEnvio().
     */
    public function configuraEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaCartao()
     * @todo   Implement adicionaCartao().
     */
    public function adicionaCartao()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaTransacao()
     * @todo   Implement adicionaTransacao().
     */
    public function adicionaTransacao()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaFormaPagamento()
     * @todo   Implement adicionaFormaPagamento().
     */
    public function adicionaFormaPagamento()
    {
        
    }
}