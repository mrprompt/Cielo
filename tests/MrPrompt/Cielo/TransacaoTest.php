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
     * Data provider
     *
     * @return mixed
     */
    public function dataHoraValidas()
    {
        return array(
            array('2014-09-10 00:00:00'),
            array('2013-01-01 22:22:22'),
            array('2014-09-12 14:20:00'),
            array('2015-03-06 20:32:00'),
        );
    }

    /**
     * Data provider
     *
     * @return mixed
     */
    public function dataHoraInvalidas()
    {
        return array(
            array('14-09-10 00:00:00'),
            array('2014-09-10'),
            array('00:00:00'),
            array(''),
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDataHora
     * @covers MrPrompt\Cielo\Transacao::getDataHora
     * @dataProvider dataHoraValidas
     */
    public function getDataHora($dataHora)
    {
        $this->object->setDataHora($dataHora);

        $this->assertEquals($dataHora, $this->object->getDataHora());
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDataHora
     * @dataProvider dataHoraValidas
     */
    public function setDataHora($dataHora)
    {
        $result = $this->object->setDataHora($dataHora);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDataHora
     * @dataProvider dataHoraInvalidas
     * @expectedException InvalidArgumentException
     */
    public function setDataHoraDisparaExcessaoComDataOuHoraInvalidos($dataHora)
    {
        $this->object->setDataHora($dataHora);
    }

    /**
     * Data provider
     *
     * @return mixed
     */
    public function numerosValidos()
    {
        return array(
            array(93938382),
            array(83727829),
            array(998372),
            array(3323),
        );
    }

    /**
     * Data provider
     *
     * @return mixed
     */
    public function numerosInvalidos()
    {
        return array(
            array('A'),
            array('XXX'),
            array(0),
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setNumero
     * @covers MrPrompt\Cielo\Transacao::getNumero
     * @dataProvider numerosValidos
     */
    public function getNumero($numero)
    {
        $this->object->setNumero($numero);

        $this->assertEquals($numero, $this->object->getNumero());
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setNumero
     * @dataProvider numerosValidos
     */
    public function setNumero($numero)
    {
        $result = $this->object->setNumero($numero);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setNumero
     * @dataProvider numerosInvalidos
     * @expectedException InvalidArgumentException
     */
    public function setNumeroDisparaExcessaoComNumeroInvalido($numero)
    {
        $this->object->setNumero($numero);
    }

    /**
     * Data provider de valores válidos
     *
     * @return mixed
     */
    public function valoresValidos()
    {
        return array(
            array(1245),
            array(1000),
            array(100),
            array(20000),
        );
    }

    /**
     * Data provider de valores inválidos
     *
     * @return mixed
     */
    public function valoresInvalidos()
    {
        return array(
            array('A'),
            array('XXX'),
            array(''),
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setValor
     * @covers MrPrompt\Cielo\Transacao::getValor
     * @dataProvider valoresValidos
     */
    public function getValor($valor)
    {
        $this->object->setValor($valor);

        $this->assertEquals($valor, $this->object->getValor());
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setValor
     * @dataProvider valoresValidos
     */
    public function setValor($valor)
    {
        $result = $this->object->setValor($valor);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setValor
     * @dataProvider valoresInvalidos
     * @expectedException InvalidArgumentException
     */
    public function setValorDisparaExcessaoComValorInvalido($valor)
    {
        $this->object->setValor($valor);
    }

    /**
     * Data provider de descrições válidas
     *
     * @return mixed
     */
    public function descricoesValidas()
    {
        return array(
            array('Teste'),
            array('Teste com Espaço'),
            array('xxxxx'),
        );
    }

    /**
     * Data provider de descrições inválidas
     *
     * @return mixed
     */
    public function descricoesInvalidas()
    {
        return array(
            array(null),
            array(''),
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDescricao
     * @dataProvider descricoesValidas
     */
    public function setDescricao($descricao)
    {
        $result = $this->object->setDescricao($descricao);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDescricao
     * @dataProvider descricoesInvalidas
     * @expectedException InvalidArgumentException
     */
    public function setDescricaoDisparaExcessaoComDescricaoInvalida($descricao)
    {
        $this->object->setDescricao($descricao);
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Transacao::setDescricao
     * @covers MrPrompt\Cielo\Transacao::getDescricao
     * @dataProvider descricoesValidas
     */
    public function getDescricao($descricao)
    {
        $this->object->setDescricao($descricao);

        $this->assertEquals($descricao, $this->object->getDescricao());
    }
}
