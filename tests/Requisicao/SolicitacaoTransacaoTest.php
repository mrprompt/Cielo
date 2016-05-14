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
namespace MrPrompt\Cielo\Tests\Requisicao;

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Idioma;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use MrPrompt\Cielo\Transacao;
use ReflectionMethod;

class SolicitacaoTransacaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SolicitacaoTransacao
     */
    protected $object;

    /**
     * @var Autorizacao
     */
    protected $autorizacao;

    /**
     * @var Cartao
     */
    protected $cartao;

    /**
     * @var Transacao
     */
    protected $transacao;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->autorizacao = $this->getMock(Autorizacao::class, [], [], '', false);
        $this->transacao   = $this->getMock(Transacao::class, [], [], '', false);
        $this->transacao->method('getDataHora')->willReturn(new \DateTimeImmutable());

        $this->cartao      = $this->getMock(Cartao::class, [], [], '', false);
        $urlRetorno        = 'http://localhost/';
        $idioma            = $this->getMock(Idioma::class, [], [], '', false);

        $this->object = new SolicitacaoTransacao(
            $this->autorizacao,
            $this->transacao,
            $this->cartao,
            $urlRetorno,
            $idioma
        );
    }

  	/**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @expectedException \InvalidArgumentException
     */
  	public function construtorDisparaExcessaoComUrlDeRetornoInvalida()
    {
        $mockAutorizacao = $this->getMock(Autorizacao::class, [], [], '', false);
        $mockTransacao   = $this->getMock(Transacao::class, [], [], '', false);
        $mockCartao      = $this->getMock(Cartao::class, [], [], '', false);
        $urlRetorno      = 'http:///';
        $idioma          = $this->getMock(Idioma::class, [], [], '', false);

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
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::getXmlInicial()
     */
    public function getXmlInicial()
    {
        $method = new ReflectionMethod($this->object, 'getXmlInicial');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     */
    public function configuraEnvio()
    {
        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     */
    public function configuraEnvioComCartao()
    {
        $mockAutorizacao = $this->getMock(Autorizacao::class, [], [], '', false);
        $mockTransacao   = $this->getMock(Transacao::class, [], [], '', false);
        $mockTransacao->method('getDataHora')->willReturn(new \DateTimeImmutable());

        $mockCartao      = $this->getMock(Cartao::class, [], [], '', false);
        $mockCartao->setCartao('4012001037141112');

        $urlRetorno      = 'http://localhost/';
        $idioma          = $this->getMock(Idioma::class, [], [], '', false);

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
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::configuraEnvio()
     */
    public function configuraEnvioComCartaoSetandoToken()
    {
        $mockAutorizacao = $this->getMock(Autorizacao::class, [], [], '', false);
        $mockAutorizacao->setModalidade(Autorizacao::MODALIDADE_BUY_PAGE_CIELO);

        $mockTransacao   = $this->getMock(Transacao::class, [], [], '', false);
        $mockTransacao->method('isGerarToken')->willReturn(true);
        $mockTransacao->method('getDataHora')->willReturn(new \DateTimeImmutable());

        $mockCartao      = $this->getMock(Cartao::class, [], [], '', false);
        $mockCartao->method('getCartao')->willReturn('4012001037141112');

        $urlRetorno      = 'http://localhost/';
        $idioma            = $this->getMock(Idioma::class, [], [], '', false);

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
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::deveAdicionarTid()
     */
    public function deveAdicionarTid()
    {
        $method = new ReflectionMethod($this->object, 'deveAdicionarTid');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaPortador()
     */
    public function adicionaPortador()
    {
        $method = new ReflectionMethod($this->object, 'adicionaPortador');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaTransacao()
     */
    public function adicionaTransacao()
    {
        $method = new ReflectionMethod($this->object, 'adicionaTransacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoTransacao::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento()
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}