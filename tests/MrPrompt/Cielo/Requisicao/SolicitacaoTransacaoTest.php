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
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     * @todo   Implement configuraEnvio().
     */
    public function configuraEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::deveAdicionarTid()
     * @todo   Implement deveAdicionarTid().
     */
    public function deveAdicionarTid()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaPortador()
     * @todo   Implement adicionaPortador().
     */
    public function adicionaPortador()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaTransacao()
     * @todo   Implement adicionaTransacao().
     */
    public function adicionaTransacao()
    {
        
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaFormaPagamento()
     * @todo   Implement adicionaFormaPagamento().
     */
    public function adicionaFormaPagamento()
    {
        
    }
}