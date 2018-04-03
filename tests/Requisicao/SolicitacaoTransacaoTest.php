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
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Idioma;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use MrPrompt\Cielo\Transacao;
use ReflectionMethod;
use PHPUnit\Framework\TestCase;

/**
 * Class SolicitacaoTransacaoTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SolicitacaoTransacaoTest extends TestCase
{
    /**
     * @var SolicitacaoTransacao
     */
    protected $object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $autorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        
        $transacao = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $transacao->method('getDataHora')->willReturn(new \DateTime());

        $cartao = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        $idioma = $this->getMockBuilder(Idioma::class)->disableOriginalConstructor()->getMock();

        $urlRetorno = 'http://localhost/';

        $this->object = new SolicitacaoTransacao(
            $autorizacao,
            $transacao,
            $cartao,
            $urlRetorno,
            $idioma
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        $this->object = null;

        parent::tearDown();
    }

  	/**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @expectedException \InvalidArgumentException
     */
  	public function construtorDisparaExcessaoComUrlDeRetornoInvalida(): void
    {
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao   = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $mockCartao      = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        $idioma          = $this->getMockBuilder(Idioma::class)->disableOriginalConstructor()->getMock();
        $urlRetorno      = 'http:///';

        $this->object = new SolicitacaoTransacao(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $urlRetorno,
            $idioma
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::getXmlInicial()
     */
    public function getXmlInicial(): void
    {
        $method = new ReflectionMethod($this->object, 'getXmlInicial');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     */
    public function configuraEnvioComCartao(): void
    {
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao   = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao->method('getDataHora')->willReturn(new \DateTime());

        $mockCartao = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        $mockCartao->setCartao('4012001037141112');

        $urlRetorno = 'http://localhost/';
        
        $idioma  = $this->getMockBuilder(Idioma::class)->disableOriginalConstructor()->getMock();

        $this->object = new SolicitacaoTransacao(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $urlRetorno,
            $idioma
        );

        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     */
    public function configuraEnvioComCartaoSetandoToken(): void
    {
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $mockAutorizacao->setModalidade(Autorizacao::MODALIDADE_BUY_PAGE_CIELO);

        $mockTransacao   = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao->method('isGerarToken')->willReturn(true);
        $mockTransacao->method('getDataHora')->willReturn(new \DateTime());

        $mockCartao      = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        $mockCartao->method('getCartao')->willReturn('4012001037141112');

        $urlRetorno      = 'http://localhost/';
        $idioma            = $this->getMockBuilder(Idioma::class)->disableOriginalConstructor()->getMock();

        $this->object = new SolicitacaoTransacao(
            $mockAutorizacao,
            $mockTransacao,
            $mockCartao,
            $urlRetorno,
            $idioma
        );

        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::deveAdicionarTid()
     */
    public function deveAdicionarTid(): void
    {
        $method = new ReflectionMethod($this->object, 'deveAdicionarTid');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaPortador()
     */
    public function adicionaPortador(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaPortador');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaTransacao()
     */
    public function adicionaTransacao(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaTransacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}