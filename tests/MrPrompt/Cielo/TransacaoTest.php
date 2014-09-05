<?php
namespace MrPrompt\Cielo;

class TransacaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Transacao
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Transacao;
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
     * @covers MrPrompt\Cielo\Transacao::setTid
     * @covers MrPrompt\Cielo\Transacao::getTid
     */
    public function getTid()
    {
        $tid    = uniqid();
        $result = $this->object->setTid($tid);
        
        $this->assertEquals($tid, $this->object->getTid());
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setTid
     * @expectedException InvalidArgumentException
     */
    public function setTidDisparaExcessaoQuandoVazio()
    {
        $this->object->setTid('');
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setTid
     */
    public function setTid()
    {
        $tid    = uniqid();
        $result = $this->object->setTid($tid);
        
        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }
    
    /**
     * data provider
     *
     * @return array
     */
    public function produtosValidos()
    {
        return array(
            array(1),
            array(2),
            array(3),
            array('A')
        );
    }
    
    /**
     * data provider
     *
     * @return array
     */
    public function produtosInvalidos()
    {
        return array(
            array(0),
            array(5),
            array(99),
            array('AAAA')
        );
    }

    /**
     * @test
     * @dataProvider produtosValidos
     * @covers MrPrompt\Cielo\Transacao::setProduto
     * @covers MrPrompt\Cielo\Transacao::getProduto
     */
    public function getProduto($produto)
    {
        $this->object->setProduto($produto);

        $this->assertEquals($produto, $this->object->getProduto());
    }

    /**
     * @test
     * @dataProvider produtosValidos
     * @covers MrPrompt\Cielo\Transacao::setProduto
     */
    public function setProduto($produto)
    {
        $result = $this->object->setProduto($produto);
        
        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }
    
    /**
     * data provider de parcelas válidas
     * 
     * @return array
     */
    public function parcelasValidas()
    {
        return array(
            array(1),
            array(3),
            array(6),
            array(12),
            array(24),
        );
    }
    
    /**
     * data provider de parcelas inválidas
     *
     * @return array
     */
    public function parcelasInvalidas()
    {
        return array(
            array(0),
            array('A'),
            array('ADFSSF'),
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setParcelas
     * @covers MrPrompt\Cielo\Transacao::getParcelas
     * @dataProvider parcelasValidas
     */
    public function getParcelas($parcelas)
    {
        $this->object->setParcelas($parcelas);
        
        $this->assertEquals($parcelas, $this->object->getParcelas());
    }

    /**
     * @test
     * @dataProvider parcelasValidas
     * @covers MrPrompt\Cielo\Transacao::setParcelas
     */
    public function setParcelas($parcelas)
    {
        $result = $this->object->setParcelas($parcelas);
        
        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @dataProvider parcelasInvalidas
     * @covers MrPrompt\Cielo\Transacao::setParcelas
     * @expectedException InvalidArgumentException
     */
    public function setParcelasDisparaExcessaoComParcelasInvalidas($parcelas)
    {
        $this->object->setParcelas($parcelas);
    }
    
    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getMoeda
     * @todo   Implement testGetMoeda().
     */
    public function getMoeda()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setMoeda
     * @todo   Implement testSetMoeda().
     */
    public function setMoeda()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getCapturar
     * @todo   Implement testGetCapturar().
     */
    public function getCapturar()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setCapturar
     * @todo   Implement testSetCapturar().
     */
    public function setCapturar()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getAutorizar
     * @todo   Implement testGetAutorizar().
     */
    public function getAutorizar()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setAutorizar
     * @todo   Implement testSetAutorizar().
     */
    public function setAutorizar()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getDataHora
     * @todo   Implement testGetDataHora().
     */
    public function getDataHora()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDataHora
     * @todo   Implement testSetDataHora().
     */
    public function setDataHora()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getNumero
     * @todo   Implement testGetNumero().
     */
    public function getNumero()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setNumero
     * @todo   Implement testSetNumero().
     */
    public function setNumero()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getValor
     * @todo   Implement testGetValor().
     */
    public function getValor()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setValor
     * @todo   Implement testSetValor().
     */
    public function setValor()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDescricao
     * @todo   Implement testSetDescricao().
     */
    public function setDescricao()
    {
        
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::getDescricao
     * @todo   Implement testGetDescricao().
     */
    public function getDescricao()
    {
        
    }
}
