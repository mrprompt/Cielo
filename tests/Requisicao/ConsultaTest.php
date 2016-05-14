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
use MrPrompt\Cielo\Requisicao\Consulta;
use MrPrompt\Cielo\Transacao;

class ConsultaTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Consulta
     */
    protected $object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $mockAutorizacao = $this->getMock(Autorizacao::class, [], [], '', false);
        $mockTransacao   = $this->getMock(Transacao::class, [], [], '', false);
        
        $this->object = new Consulta($mockAutorizacao, $mockTransacao);
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
     * @covers \MrPrompt\Cielo\Requisicao\Consulta::getXmlInicial()
     * @todo   Implement getXmlInicial().
     */
    public function getXmlInicial()
    {
        
    }
}