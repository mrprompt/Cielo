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
namespace MrPrompt\Cielo\Tests;

use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cartao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Requisicao\SolicitacaoTransacao;
use MrPrompt\Cielo\Transacao;

class ClienteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cliente
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $mockAutorizacao = $this->getMock(Autorizacao::class, [], [], '', false);

        $this->object = new Cliente($mockAutorizacao);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cliente::iniciaTransacao()
     */
    public function iniciaTransacaoDeveRetornarUmObjectSolicitacaoTransacao()
    {
        $transacao  = $this->getMock(
            Transacao::class, [
                'getDataHora' =>  'ooo'
            ], [], '', true);
        $cartao     = $this->getMock(Cartao::class, [], [], '', false);
        $url        = 'http://localhost';

        $result = $this->object->iniciaTransacao($transacao, $cartao, $url);

        $this->assertInstanceOf(SolicitacaoTransacao::class, $result);
    }
}
