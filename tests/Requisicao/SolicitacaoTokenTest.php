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
use MrPrompt\Cielo\Idioma\Idioma;
use MrPrompt\Cielo\Requisicao\SolicitacaoToken;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Class SolicitacaoTokenTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class SolicitacaoTokenTest extends TestCase
{
    /**
     *
     * @var SolicitacaoToken
     */
    protected $object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $mockCartao = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        $idioma = $this->getMockBuilder(Idioma::class)->disableOriginalConstructor()->getMock();
        $urlRetorno = 'http://localhost/';

        $this->object = new SolicitacaoToken($mockAutorizacao, $mockTransacao, $mockCartao, $urlRetorno, $idioma);
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::configuraEnvio()
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::adicionaCartao()
     */
    public function adicionaCartao(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaCartao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}