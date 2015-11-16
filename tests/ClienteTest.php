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

use ReflectionProperty;

use MrPrompt\Cielo\Cliente;

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
        $mockAutorizacao = $this->getMock('MrPrompt\Cielo\Autorizacao', array(), array(), '', false);

        $this->object = new Cliente($mockAutorizacao);
    }

    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Cliente::getAmbiente
     */
    public function ambienteDeveRetornarPropriedadeAmbiente()
    {
        $reflection = new ReflectionProperty(Cliente::class, 'ambiente');
        $reflection->setAccessible(true);
        $reflection->setValue($this->object, 'teste');

        $this->assertEquals('teste', $this->object->getAmbiente());
    }

    /**
     * @test
     *
     * @dataProvider ambientesValidos
     *
     * @covers \MrPrompt\Cielo\Cliente::__construct
     * @covers \MrPrompt\Cielo\Cliente::setAmbiente
     * @covers \MrPrompt\Cielo\Cliente::getAmbiente
     */
    public function ambienteDeveSerValido($valor)
    {
        $this->object->setAmbiente($valor);

        $this->assertEquals($valor, $this->object->getAmbiente());
    }

    /**
     * Data Provider
     * @return array
     */
    public function ambientesValidos()
    {
        return array(
            array('teste', 'teste'),
            array('produção', 'produção'),
        );
    }

    /**
     * @test
     *
     * @dataProvider ambientesInvalidos
     *
     * @covers \MrPrompt\Cielo\Cliente::__construct
     * @covers \MrPrompt\Cielo\Cliente::setAmbiente
     *
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaAmbienteInvalido($valor)
    {
        $this->object->setAmbiente($valor);
    }

    /**
     * Data Provider
     *
     * @return array
     */
    public function ambientesInvalidos()
    {
        return array(
            array(''),
            array(null),
            array('test')
        );
    }

    /**
     * @test
     *
     * @dataProvider idiomasValidos
     *
     * @covers \MrPrompt\Cielo\Cliente::__construct
     * @covers \MrPrompt\Cielo\Cliente::setIdioma
     * @covers \MrPrompt\Cielo\Cliente::getIdioma
     */
    public function idiomaDeveSerValido($valor, $expected)
    {
        $this->object->setIdioma($valor);
        
        $this->assertEquals($expected, $this->object->getIdioma());
    }

    /**
     * Data Provider
     *
     * @return array
     */
    public function idiomasValidos()
    {
        return array(
            array('PT', 'PT'),
            array('pT', 'PT'),
            array('Pt', 'PT'),
            array('pt', 'PT'),
            array('EN', 'EN'),
            array('En', 'EN'),
            array('eN', 'EN'),
            array('en', 'EN'),
            array('ES', 'ES'),
            array('Es', 'ES'),
            array('eS', 'ES'),
            array('es', 'ES'),
        );
    }

    /**
     * @test
     *
     * @dataProvider idiomasInvalidos
     *
     * @expectedException \InvalidArgumentException
     *
     * @covers \MrPrompt\Cielo\Cliente::__construct
     * @covers \MrPrompt\Cielo\Cliente::setAmbiente
     */
    public function deveLancarErroCasoRecebaIdiomaInvalido($valor)
    {
        $this->object->setAmbiente($valor);
    }

    /**
     * Data Provider
     *
     * @return array
     */
    public function idiomasInvalidos()
    {
        return array(
            array(''),
            array(null),
            array('pt-br')
        );
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Cliente::__construct
     * @covers \MrPrompt\Cielo\Cliente::getIdiomas
     */
    public function getIdiomasDeveRetornarArray()
    {
        $this->assertTrue(is_array($this->object->getIdiomas()));
    }
    
    /**
     * @test
     *
     * @covers \MrPrompt\Cielo\Cliente::__construct
     * @covers \MrPrompt\Cielo\Cliente::getAmbientes
     */
    public function getAmbientesDeveRetornarArray()
    {
        $this->assertTrue(is_array($this->object->getAmbientes()));
    }
}
