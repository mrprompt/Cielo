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
use PHPUnit_Framework_TestCase;

class AutorizacaoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * 
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     * @covers \MrPrompt\Cielo\Autorizacao::getNumero
     * @covers \MrPrompt\Cielo\Autorizacao::getChave
     * @covers \MrPrompt\Cielo\Autorizacao::getModalidade
     */
    public function aoConstruirDeveConfigurarDados()
    {
        $autorizacao = new Autorizacao('teste', 'teste', Autorizacao::MODALIDADE_BUY_PAGE_LOJA);

        $this->assertEquals('teste', $autorizacao->getNumero());
        $this->assertEquals('teste', $autorizacao->getChave());
        $this->assertEquals(Autorizacao::MODALIDADE_BUY_PAGE_LOJA, $autorizacao->getModalidade());
    }

    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     * @covers \MrPrompt\Cielo\Autorizacao::getNumero
     */
    public function aoConstruirDeveTruncarNumeroEm20Digitos()
    {
        $autorizacao = new Autorizacao(str_repeat('a', 30), 'teste');

        $this->assertEquals(str_repeat('a', 20), $autorizacao->getNumero());
    }

    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     * @covers \MrPrompt\Cielo\Autorizacao::getChave
     */
    public function aoConstruirDeveTruncarChaveEm100Digitos()
    {
        $autorizacao = new Autorizacao('teste', str_repeat('a', 130));

        $this->assertEquals(str_repeat('a', 100), $autorizacao->getChave());
    }

    /**
     * @test
     * 
     * @dataProvider valoresInvalidos
     *
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     * 
     * @expectedException \InvalidArgumentException
     */
    public function aoConstruirNumeroNaoPodeTerValorInvalido($valor)
    {
        $autorizacao = new Autorizacao($valor, 'teste');
    }

    /**
     * @test
     *
     * @dataProvider valoresInvalidos
     *
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     * 
     * @expectedException \InvalidArgumentException
     */
    public function aoConstruirChaveNaoPodeTerValorInvalido($valor)
    {
        $autorizacao = new Autorizacao('teste', $valor);
    }
    
    /**
     * @test
     * 
     * @dataProvider valoresInvalidos
     *
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     * 
     * @expectedException \TypeError
     */
    public function aoConstruirModalideNaoPodeValorInvalido($valor)
    {
        $autorizacao = new Autorizacao('teste', 'teste', $valor);
    }

    /**
     * @test
     *
     * @dataProvider modalidadesInvalidas
     * 
     * @covers \MrPrompt\Cielo\Autorizacao::__construct
     * @covers \MrPrompt\Cielo\Autorizacao::setNumero
     * @covers \MrPrompt\Cielo\Autorizacao::setChave
     * @covers \MrPrompt\Cielo\Autorizacao::setModalidade
     *
     * @expectedException \InvalidArgumentException
     */
    public function setModalidadeDisparaExcessaoSeAModalidadeNaoForPermitida($modalidade)
    {
        $autorizacao = new Autorizacao('teste', 'teste');
        $autorizacao->setModalidade($modalidade);
    }
    
    /**
     * Data Provider
     * 
     * @return mixed
     */
    public function valoresInvalidos()
    {
        return array(
            array(null),
            array(15.5),
            array(''),
            array(array('dfgdfg')),
            array((object) array('dfgdfg' => 'sdfsdf'))
        );
    }

    /**
     * Data Provider
     *
     * @return array
     */
    public function modalidadesInvalidas()
    {
        return [
            [
                0
            ],
            [
                3
            ],
            [
                4
            ],
        ];
    }
}
