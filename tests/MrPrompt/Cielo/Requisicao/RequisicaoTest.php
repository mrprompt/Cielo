<?php
namespace MrPrompt\Cielo\Requisicao;

class RequisicaoExtendida extends Requisicao 
{
    public function getXmlInicial()
    {
        //return parent::getXmlInicial();
    }
}

class RequisicaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Requisicao
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
        
        $this->object = new RequisicaoExtendida(
            $mockAutorizacao,
            $mockTransacao
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
     * @covers Requisicao::configuraAutenticacao()
     * @todo   Implement configuraAutenticacao().
     */
    public function configuraAutenticacao()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::configuraTransacao()
     * @todo   Implement configuraTransacao().
     */
    public function configuraTransacao()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::getEnvio()
     * @todo   Implement getEnvio().
     */
    public function getEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::getResposta()
     * @todo   Implement getResposta().
     */
    public function getResposta()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::setResposta()
     * @todo   Implement setResposta().
     */
    public function setResposta()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::configuraEnvio()
     * @todo   Implement configuraEnvio().
     */
    public function configuraEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::deveAdicionarTid()
     * @todo   Implement deveAdicionarTid().
     */
    public function deveAdicionarTid()
    {
        
    }
    
    /**
     * @test
     * @covers Requisicao::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
}