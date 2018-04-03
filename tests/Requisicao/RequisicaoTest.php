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

namespace MrPrompt\Cielo\Tests\Requisicao;

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Requisicao\Requisicao;
use MrPrompt\Cielo\Transacao;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use SimpleXMLElement;

/**
 * Class RequisicaoTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class RequisicaoTest extends TestCase
{
    /**
     * @var Requisicao
     */
    protected $object;

    /**
     * @var Autorizacao
     */
    protected $autorizacao;

    /**
     * @var Transacao
     */
    protected $transacao;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->autorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $this->transacao   = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $this->object      = $this->getMockForAbstractClass(Requisicao::class, [$this->autorizacao, $this->transacao]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        $this->autorizacao  = null;
        $this->transacao    = null;
        $this->object       = null;
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getModalidadeIntegracao()
     */
    public function getModalidadeIntegracao(): void
    {
        $result = $this->object->getModalidadeIntegracao();

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraAutenticacao()
     */
    public function configuraAutenticacao(): void
    {
        $method = new ReflectionMethod($this->object, 'configuraAutenticacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraTransacao()
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::deveAdicionarTid()
     */
    public function configuraTransacao(): void
    {
        $method = new ReflectionMethod($this->object, 'configuraTransacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraTransacao()
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::deveAdicionarTid()
     */
    public function configuraTransacaoSemAdicionarTidDeveRetornarVazio(): void
    {
        $method = new ReflectionMethod($this->object, 'configuraTransacao');
        $method->setAccessible(true);

        $this->object->setAdicionarTid(false);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getEnvio()
     */
    public function getEnvio(): void
    {
        $result = $this->object->getEnvio();

        $this->assertInstanceOf(SimpleXMLElement::class, $result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getResposta()
     */
    public function getResposta(): void
    {
        $result = $this->object->getResposta();

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::setResposta()
     */
    public function setResposta(): void
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->appendChild($dom->createElement('resposta'));

        $xml    = new SimpleXMLElement($dom->saveXML());
        $result = $this->object->setResposta($xml->__toString());

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraEnvio()
     */
    public function configuraEnvio(): void
    {
        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getAdicionarTid()
     */
    public function getAdicionarTid(): void
    {
        $result = $this->object->getAdicionarTid();

        $this->assertTrue(is_bool($result));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::setAdicionarTid()
     */
    public function setAdicionarTid(): void
    {
        $result = $this->object->setAdicionarTid(true);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::deveAdicionarTid()
     */
    public function deveAdicionarTid(): void
    {
        $method = new ReflectionMethod($this->object, 'deveAdicionarTid');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertTrue(is_bool($result));
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getXmlInicial()
     */
    public function getXmlInicial(): void
    {
        $method = new ReflectionMethod($this->object, 'getXmlInicial');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertNotEmpty($result);
    }
}