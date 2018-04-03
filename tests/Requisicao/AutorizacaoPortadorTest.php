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
use MrPrompt\Cielo\Idioma;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Requisicao\AutorizacaoPortador;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Class AutorizacaoPortadorTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class AutorizacaoPortadorTest extends TestCase
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
    protected function setUp(): void
    {
        $autorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $cartao = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        $idioma = $this->getMockBuilder(Idioma::class)->disableOriginalConstructor()->getMock();
        
        $transacao = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $transacao->method('getDataHora')->willReturn(new \DateTime);

        $this->object = new AutorizacaoPortador($autorizacao, $transacao, $cartao, $idioma);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::configuraEnvio()
     */
    public function configuraEnvio(): void
    {
        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaCartao()
     */
    public function adicionaCartao(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaCartao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaTransacao()
     */
    public function adicionaTransacao(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaTransacao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\AutorizacaoPortador::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertNull($result);
    }
}