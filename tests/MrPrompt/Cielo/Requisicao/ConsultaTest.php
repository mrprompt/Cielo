<?php
namespace MrPrompt\Cielo\Requisicao;

class ConsultaTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Consulta
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
        
        $this->object = new Consulta(
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
     * @covers MrPrompt\Cielo\Requisicao\Consulta::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
}