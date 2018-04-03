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
use MrPrompt\Cielo\Requisicao\CancelamentoTransacao;
use MrPrompt\Cielo\Transacao;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Class CancelamentoTransacaoTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class CancelamentoTransacaoTest extends TestCase
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
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao   = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        
        $this->object = new CancelamentoTransacao($mockAutorizacao, $mockTransacao);
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
     *
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\CancelamentoTransacao::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\CancelamentoTransacao::configuraEnvio()
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
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\CancelamentoTransacao::configuraEnvio()
     */
    public function configuraEnvioComValor(): void
    {
        $mockAutorizacao = $this->getMockBuilder(Autorizacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao   = $this->getMockBuilder(Transacao::class)->disableOriginalConstructor()->getMock();
        $mockTransacao->method('getValor')->willReturn(100);
        
        $this->object = new CancelamentoTransacao($mockAutorizacao, $mockTransacao);

        $method = new ReflectionMethod($this->object, 'configuraEnvio');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);

        $this->assertEmpty($result);
    }
}