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

use MrPrompt\Cielo\Requisicao\Requisicao;

class ExtendRequisicao extends Requisicao
{
    protected function getXmlInicial()
    {
        return sprintf(
            '<%s id="%d" versao="%s"></%s>',
            'requisicao-test',
            1,
            1.0,
            'requisicao-test'
        );
    }
}

class RequisicaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Requisicao
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
        
        $this->object = new ExtendRequisicao(
            $mockAutorizacao,
            $mockTransacao
        );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraAutenticacao()
     * @todo   Implement configuraAutenticacao().
     */
    public function configuraAutenticacao()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraTransacao()
     * @todo   Implement configuraTransacao().
     */
    public function configuraTransacao()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getEnvio()
     * @todo   Implement getEnvio().
     */
    public function getEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getResposta()
     * @todo   Implement getResposta().
     */
    public function getResposta()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::setResposta()
     * @todo   Implement setResposta().
     */
    public function setResposta()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::configuraEnvio()
     * @todo   Implement configuraEnvio().
     */
    public function configuraEnvio()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::deveAdicionarTid()
     * @todo   Implement deveAdicionarTid().
     */
    public function deveAdicionarTid()
    {
        
    }
    
    /**
     * @test
     * @covers \MrPrompt\Cielo\Requisicao\Requisicao::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
}