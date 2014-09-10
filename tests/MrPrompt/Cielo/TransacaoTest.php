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
     * data provider de moedas válidas
     *
     * @return array
     */
    public function moedasValidas()
    {
        return array(
            array(986), // R$ real
            array(998), // Dólar EUA 
            array(997), // Dólar EUA 
            array(858), // Peso Uruguaio
        );
    }
    
    /**
     * data provider de moedas inválidas
     *
     * @return array
     */
    public function moedasInvalidas()
    {
        return array(
            array(0),
            array('A'),
            array('ADFSSF'),
        );
    }
    
    /**
     * @test
     * @dataProvider moedasValidas
     * @covers MrPrompt\Cielo\Transacao::setMoeda
     * @covers MrPrompt\Cielo\Transacao::getMoeda
     */
    public function getMoeda($moeda)
    {
        $result = $this->object->setMoeda($moeda);
        
        $this->assertEquals($moeda, $this->object->getMoeda());
    }

    /**
     * @test
     * @dataProvider moedasValidas
     * @covers MrPrompt\Cielo\Transacao::setMoeda
     */
    public function setMoeda($moeda)
    {
        $result = $this->object->setMoeda($moeda);
        
        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }
    
    /**
     * @test
     * @dataProvider moedasInvalidas
     * @covers MrPrompt\Cielo\Transacao::setMoeda
     * @expectedException InvalidArgumentException
     */
    public function setMoedaDisparaExcessaoComMoedaInvalida($moeda)
    {
        $this->object->setMoeda($moeda);
    }
    
    /**
     * @return mixed
     */
    public function capturasValidas()
    {
        return array(
            array('true'),
            array('false'),
        );
    }
    
    /**
     * @return mixed
     */
    public function capturasInvalidas()
    {
        return array(
            array('verdadeiro'),
            array('falso'),
        );
    }

    /**
     * @test
     * @dataProvider capturasValidas
     * @covers MrPrompt\Cielo\Transacao::setCapturar
     * @covers MrPrompt\Cielo\Transacao::getCapturar
     */
    public function getCapturar($capturar)
    {
        $this->object->setCapturar($capturar);
        
        $this->assertEquals($capturar, $this->object->getCapturar());
    }

    /**
     * @test
     * @dataProvider capturasValidas
     * @covers MrPrompt\Cielo\Transacao::setCapturar
     */
    public function setCapturar($capturar)
    {
        $result = $this->object->setCapturar($capturar);
        
        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @dataProvider capturasInvalidas
     * @covers MrPrompt\Cielo\Transacao::setCapturar
     * @expectedException InvalidArgumentException
     */
    public function setCapturarDisparaExcessaoComCapturaInvalida($capturar)
    {
        $this->object->setCapturar($capturar);
    }
    
    /**
     * Data provider de autorizações válidas
     * 
     * @return mixed
     */
    public function autorizacoesValidas()
    {
        return array(
            array(0),
            array(1),
            array(2),
            array(3),
        );
    } 
    
    /**
     * Data provider de autorizações inválidas
     * 
     * @return mixed
     */
    public function autorizacoesInvalidas()
    {
        return array(
            array(4),
            array('5'),
            array('A'),
            array('XXX'),
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setAutorizar
     * @covers MrPrompt\Cielo\Transacao::getAutorizar
     * @dataProvider autorizacoesValidas
     */
    public function getAutorizar($autorizar)
    {
        $this->object->setAutorizar($autorizar);
        
        $this->assertEquals($autorizar, $this->object->getAutorizar());
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setAutorizar
     * @dataProvider autorizacoesValidas
     */
    public function setAutorizar($autorizar)
    {
        $result = $this->object->setAutorizar($autorizar);
        
        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setAutorizar
     * @dataProvider autorizacoesInvalidas
     * @expectedException InvalidArgumentException
     */
    public function setAutorizarDisparaExcessaoComAutorizacaoInvalida($autorizar)
    {
        $this->object->setAutorizar($autorizar);
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
