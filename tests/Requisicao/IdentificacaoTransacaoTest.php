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
use MrPrompt\Cielo\Requisicao\IdentificacaoTransacao;
use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cartao;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Class IdentificacaoTransacaoTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class IdentificacaoTransacaoTest extends TestCase
{
    /**
     *
     * @var IdentificacaoTransacao
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
        $mockCartao      = $this->getMockBuilder(Cartao::class)->disableOriginalConstructor()->getMock();
        
        $this->object = new IdentificacaoTransacao($mockAutorizacao, $mockTransacao, $mockCartao);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::configuraEnvio()
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
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::deveAdicionarTid()
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
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\IdentificacaoTransacao::adicionaFormaPagamento()
     */
    public function adicionaFormaPagamento(): void
    {
        $method = new ReflectionMethod($this->object, 'adicionaFormaPagamento');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}