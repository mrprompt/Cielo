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

use MrPrompt\Cielo\Requisicao\SolicitacaoToken;
use ReflectionMethod;

class SolicitacaoTokenTest extends \PHPUnit_Framework_TestCase
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
    protected function setUp()
    {
        $mockAutorizacao = $this->getMock('MrPrompt\Cielo\Autorizacao', array(), array(), '', false);
        $mockTransacao   = $this->getMock('MrPrompt\Cielo\Transacao', array(), array(), '', false);
        $mockCartao      = $this->getMock('MrPrompt\Cielo\Cartao', array(), array(), '', false);
        $urlRetorno      = 'http://localhost/';
        $idioma          = 'PT';

        $this->object = new SolicitacaoToken(
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::getXmlInicial()
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::configuraEnvio()
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
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::__construct()
     * @covers \MrPrompt\Cielo\Requisicao\SolicitacaoToken::adicionaCartao()
     */
    public function adicionaCartao()
    {
        $method = new ReflectionMethod($this->object, 'adicionaCartao');
        $method->setAccessible(true);

        $result = $method->invoke($this->object);
        
        $this->assertEmpty($result);
    }
}