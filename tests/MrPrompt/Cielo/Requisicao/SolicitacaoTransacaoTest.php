<?php
namespace MrPrompt\Cielo\Requisicao;

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
        $this->object = new SolicitacaoTransacao($mockAutorizacao);
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
     * @covers SolicitacaoTransacao::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
    
    /**
     * @test
     * @covers SolicitacaoTransacao::configuraEnvio()
     * @todo   Implement configuraEnvio().
     */
    public function configuraEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers SolicitacaoTransacao::deveAdicionarTid()
     * @todo   Implement deveAdicionarTid().
     */
    public function deveAdicionarTid()
    {
        
    }
    
    /**
     * @test
     * @covers SolicitacaoTransacao::adicionaPortador()
     * @todo   Implement adicionaPortador().
     */
    public function adicionaPortador()
    {
        
    }
    
    /**
     * @test
     * @covers SolicitacaoTransacao::adicionaTransacao()
     * @todo   Implement adicionaTransacao().
     */
    public function adicionaTransacao()
    {
        
    }
    
    /**
     * @test
     * @covers SolicitacaoTransacao::adicionaFormaPagamento()
     * @todo   Implement adicionaFormaPagamento().
     */
    public function adicionaFormaPagamento()
    {
        
    }
}