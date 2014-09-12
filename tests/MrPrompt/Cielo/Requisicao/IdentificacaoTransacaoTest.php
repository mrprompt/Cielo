<?php
namespace MrPrompt\Cielo\Requisicao;

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
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::configuraEnvio()
     * @todo   Implement configuraEnvio().
     */
    public function configuraEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::deveAdicionarTid()
     * @todo   Implement deveAdicionarTid().
     */
    public function deveAdicionarTid()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::adicionaFormaPagamento()
     * @todo   Implement adicionaFormaPagamento().
     */
    public function adicionaFormaPagamento()
    {
        
    }
}