<?php
/**
 * Cielo
 *
 * Cliente para o Web Service da Cielo.
 *
 * O Web Service permite efetuar vendas com cartões de bandeira
 * VISA e Mastercard, tanto no débito quanto em compras a vista ou parceladas.
 *
 * Licença
 * Este código fonte está sob a licença GPL-3.0+
 *
 * @category   Library
 * @package    MrPrompt\Cielo\Tests
 * @subpackage Cliente
 * @copyright  Thiago Paes <mrprompt@gmail.com> (c) 2013
 * @license    GPL-3.0+
 */
declare(strict_types=1);

namespace MrPrompt\Cielo\Tests;

use MrPrompt\Cielo\Transacao;
use PHPUnit\Framework\TestCase;

/**
 * Class TransacaoTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class TransacaoTest extends TestCase
{
    /**
     * @var Transacao
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Transacao;
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setTid
     * @covers \MrPrompt\Cielo\Transacao::getTid
     */
    public function getTid(): void
    {
        $tid    = uniqid();
        $result = $this->object->setTid($tid);

        $this->assertEquals($tid, $this->object->getTid());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setTid
     * @expectedException InvalidArgumentException
     */
    public function setTidDisparaExcessaoQuandoVazio(): void
    {
        $this->object->setTid('');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setTid
     */
    public function setTid(): void
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
    public function produtosValidos(): array
    {
        return array(
            array('1'),
            array('2'),
            array('3'),
            array('A')
        );
    }

    /**
     * data provider
     *
     * @return array
     */
    public function produtosInvalidos(): array
    {
        return array(
            array('5'),
            array('99'),
            array('AAAA')
        );
    }

    /**
     * @test
     * @dataProvider produtosValidos
     * @covers \MrPrompt\Cielo\Transacao::setProduto
     * @covers \MrPrompt\Cielo\Transacao::getProduto
     */
    public function getProduto($produto): void
    {
        $this->object->setProduto($produto);

        $this->assertEquals($produto, $this->object->getProduto());
    }

    /**
     * @test
     * @dataProvider produtosValidos
     * @covers \MrPrompt\Cielo\Transacao::setProduto
     */
    public function setProduto($produto): void
    {
        $result = $this->object->setProduto($produto);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @dataProvider produtosInvalidos
     * @covers \MrPrompt\Cielo\Transacao::setProduto
     * @expectedException \InvalidArgumentException
     */
    public function setProdutoDisparaExcessaoComProdutoInvalido($produto): void
    {
        $result = $this->object->setProduto($produto);
    }

    /**
     * data provider de parcelas válidas
     *
     * @return array
     */
    public function parcelasValidas(): array
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
    public function parcelasInvalidas(): array
    {
        return array(
            array('A'),
            array('ADFSSF'),
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setParcelas
     * @covers \MrPrompt\Cielo\Transacao::getParcelas
     * @dataProvider parcelasValidas
     */
    public function getParcelas($parcelas): void
    {
        $this->object->setParcelas($parcelas);

        $this->assertEquals($parcelas, $this->object->getParcelas());
    }

    /**
     * @test
     * @dataProvider parcelasValidas
     * @covers \MrPrompt\Cielo\Transacao::setParcelas
     */
    public function setParcelas($parcelas): void
    {
        $result = $this->object->setParcelas($parcelas);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @dataProvider parcelasInvalidas
     * @covers \MrPrompt\Cielo\Transacao::setParcelas
     * @expectedException \TypeError
     */
    public function setParcelasDisparaExcessaoComParcelasInvalidas($parcelas): void
    {
        $this->object->setParcelas($parcelas);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setParcelas
     * @expectedException \InvalidArgumentException
     */
    public function setParcelasDisparaExcessaoComParcelaZerada(): void
    {
        $this->object->setParcelas(0);
    }

    /**
     * data provider de moedas válidas
     *
     * @return array
     */
    public function moedasValidas(): array
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
    public function moedasInvalidas(): array
    {
        return array(
            array('A'),
            array('ADFSSF'),
        );
    }

    /**
     * @test
     * @dataProvider moedasValidas
     * @covers \MrPrompt\Cielo\Transacao::setMoeda
     * @covers \MrPrompt\Cielo\Transacao::getMoeda
     */
    public function getMoeda($moeda): void
    {
        $result = $this->object->setMoeda($moeda);

        $this->assertEquals($moeda, $this->object->getMoeda());
    }

    /**
     * @test
     * @dataProvider moedasValidas
     * @covers \MrPrompt\Cielo\Transacao::setMoeda
     */
    public function setMoeda($moeda): void
    {
        $result = $this->object->setMoeda($moeda);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @dataProvider moedasInvalidas
     * @covers \MrPrompt\Cielo\Transacao::setMoeda
     * @expectedException \TypeError
     */
    public function setMoedaDisparaExcessaoComMoedaInvalida($moeda): void
    {
        $this->object->setMoeda($moeda);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setMoeda
     * @expectedException \TypeError
     */
    public function setMoedaDisparaExcessaoComMoedaEmBranco(): void
    {
        $this->object->setMoeda('');
    }

    /**
     * Data provider
     * @return array
     */
    public function capturasValidas(): array
    {
        return array(
            array(true),
            array(false),
        );
    }

    /**
     * Data provider
     * @return mixed
     */
    public function capturasInvalidas(): array
    {
        return array(
            array('verdadeiro'),
            array('falso'),
        );
    }

    /**
     * @test
     * @dataProvider capturasValidas
     * @covers \MrPrompt\Cielo\Transacao::setCapturar
     * @covers \MrPrompt\Cielo\Transacao::getCapturar
     */
    public function getCapturar($capturar): void
    {
        $this->object->setCapturar($capturar);

        $this->assertEquals($capturar, $this->object->getCapturar());
    }

    /**
     * @test
     * @dataProvider capturasValidas
     * @covers \MrPrompt\Cielo\Transacao::setCapturar
     */
    public function setCapturar($capturar): void
    {
        $result = $this->object->setCapturar($capturar);

        $this->assertInstanceOf(Transacao::class, $result);
    }

    /**
     * @test
     * @dataProvider capturasInvalidas
     * @covers \MrPrompt\Cielo\Transacao::setCapturar
     * @expectedException \TypeError
     */
    public function setCapturarDisparaExcessaoComCapturaInvalida($capturar): void
    {
        $this->object->setCapturar($capturar);
    }

    /**
     * Data provider de autorizações válidas
     *
     * @return array
     */
    public function autorizacoesValidas(): array
    {
        return array(
            array(0),
            array(1),
            array(2),
            array(3),
            array(4),
        );
    }

    /**
     * Data provider de autorizações inválidas
     *
     * @return array
     */
    public function autorizacoesInvalidas(): array
    {
        return array(
            array('A'),
            array('XXX'),
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setAutorizar
     * @covers \MrPrompt\Cielo\Transacao::getAutorizar
     * @dataProvider autorizacoesValidas
     */
    public function getAutorizar($autorizar): void
    {
        $this->object->setAutorizar($autorizar);

        $this->assertEquals($autorizar, $this->object->getAutorizar());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setAutorizar
     * @dataProvider autorizacoesValidas
     */
    public function setAutorizar($autorizar): void
    {
        $result = $this->object->setAutorizar($autorizar);

        $this->assertInstanceOf(Transacao::class, $result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setAutorizar
     * @dataProvider autorizacoesInvalidas
     * @expectedException \TypeError
     */
    public function setAutorizarDisparaExcessaoComAutorizacaoInvalida($autorizar): void
    {
        $this->object->setAutorizar($autorizar);
    }

    /**
     * Data provider
     *
     * @return mixed
     */
    public function dataHoraValidas(): array
    {
        return array(
            array(new \DateTime('2014-09-10 00:00:00')),
            array(new \DateTime('2013-01-01 22:22:22')),
            array(new \DateTime('2014-09-12 14:20:00')),
            array(new \DateTime('2015-03-06 20:32:00')),
        );
    }

    /**
     * Data provider
     *
     * @return mixed
     */
    public function dataHoraInvalidas(): array
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
     * @covers \MrPrompt\Cielo\Transacao::setDataHora
     * @covers \MrPrompt\Cielo\Transacao::getDataHora
     * @dataProvider dataHoraValidas
     */
    public function getDataHora($dataHora): void
    {
        $this->object->setDataHora($dataHora);

        $this->assertEquals($dataHora, $this->object->getDataHora());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setDataHora
     * @dataProvider dataHoraValidas
     */
    public function setDataHora($dataHora): void
    {
        $result = $this->object->setDataHora($dataHora);

        $this->assertInstanceOf(Transacao::class, $result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setDataHora
     * @dataProvider dataHoraInvalidas
     * @expectedException \TypeError
     */
    public function setDataHoraDisparaExcessaoComDataOuHoraInvalidos($dataHora): void
    {
        $this->object->setDataHora($dataHora);
    }

    /**
     * Data provider
     *
     * @return mixed
     */
    public function numerosValidos(): array
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
    public function numerosInvalidos(): array
    {
        return array(
            array('A'),
            array('XXX'),
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setNumero
     * @covers \MrPrompt\Cielo\Transacao::getNumero
     * @dataProvider numerosValidos
     */
    public function getNumero($numero): void
    {
        $this->object->setNumero($numero);

        $this->assertEquals($numero, $this->object->getNumero());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setNumero
     * @dataProvider numerosValidos
     */
    public function setNumero($numero): void
    {
        $result = $this->object->setNumero($numero);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setNumero
     * @dataProvider numerosInvalidos
     * @expectedException \TypeError
     */
    public function setNumeroDisparaExcessaoComNumeroInvalido($numero): void
    {
        $this->object->setNumero($numero);
    }

    /**
     * Data provider de valores válidos
     *
     * @return mixed
     */
    public function valoresValidos(): array
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
    public function valoresInvalidos(): array
    {
        return array(
            array('A'),
            array('XXX'),
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setValor
     * @covers \MrPrompt\Cielo\Transacao::getValor
     * @dataProvider valoresValidos
     */
    public function getValor($valor): void
    {
        $this->object->setValor($valor);

        $this->assertEquals($valor, $this->object->getValor());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setValor
     * @dataProvider valoresValidos
     */
    public function setValor($valor): void
    {
        $result = $this->object->setValor($valor);

        $this->assertInstanceOf('MrPrompt\Cielo\Transacao', $result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setValor
     * @dataProvider valoresInvalidos
     * @expectedException \TypeError
     */
    public function setValorDisparaExcessaoComValorInvalido($valor): void
    {
        $this->object->setValor($valor);
    }

    /**
     * Data provider de descrições válidas
     *
     * @return mixed
     */
    public function descricoesValidas(): array
    {
        return array(
            array('Teste'),
            array('Teste com Espaço'),
            array('xxxxx'),
            array('')
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setDescricao
     * @dataProvider descricoesValidas
     */
    public function setDescricao($descricao): void
    {
        $result = $this->object->setDescricao($descricao);

        $this->assertInstanceOf(Transacao::class, $result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setDescricao
     * @covers \MrPrompt\Cielo\Transacao::getDescricao
     * @dataProvider descricoesValidas
     */
    public function getDescricao($descricao): void
    {
        $this->object->setDescricao($descricao);

        $this->assertEquals($descricao, $this->object->getDescricao());
    }
  
    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::isGerarToken
     */
  	public function isGerarTokenDeveRetornarBooleano(): void
    {
      	$this->assertTrue(is_bool($this->object->isGerarToken()));
    }
  
  	/**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::setGerarToken()
     */
  	public function setGerarTokenRetornaInstanciaDoProprioObjeto(): void
    {
      	$this->assertInstanceOf(Transacao::class, $this->object->setGerarToken(true));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::__construct()
     * @covers \MrPrompt\Cielo\Transacao::getDataHora()
     */
    public function ConstrutorSemParametrosDeveIniciarDataHoraComValorAtual(): void
    {
        $object = new Transacao();

        $this->assertInstanceOf(Transacao::class, $object);
        $this->assertInstanceOf(\DateTime::class, $object->getDataHora());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::__construct()
     * @covers \MrPrompt\Cielo\Transacao::getDataHora()
     */
    public function ConstrutorComObjetoDateTimeDeveIniciarSemErros(): void
    {
        $hoje = new \DateTime();

        $object = new Transacao($hoje);

        $this->assertInstanceOf(Transacao::class, $object);
        $this->assertEquals($hoje, $object->getDataHora());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Transacao::__construct()
     * @expectedException \TypeError
     */
    public function ConstrutorComObjectErradoDeveDispararExcessao(): void
    {
        $hoje = date('y-m-d');

        $object = new Transacao($hoje);

        $this->assertInstanceOf(Transacao::class, $object);
    }
}
