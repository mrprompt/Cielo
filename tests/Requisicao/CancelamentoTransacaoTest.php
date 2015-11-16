<?php
namespace MrPrompt\Cielo\Tests\Requisicao;

use MrPrompt\Cielo\Requisicao\CancelamentoTransacao;
use ReflectionMethod;

class CancelamentoTransacaoTest extends \PHPUnit_Framework_TestCase
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
        
        $this->object = new CancelamentoTransacao(
            $mockAutorizacao,
            $mockTransacao
        );
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\CancelamentoTransacao::getXmlInicial()
     */
    public function getXmlInicial()
    {
        $method = new ReflectionMethod($this->object, 'getXmlInicial');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNotEmpty($result);
    }
}