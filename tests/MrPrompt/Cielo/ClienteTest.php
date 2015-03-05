<?php
namespace MrPrompt\Cielo;

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
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() { }

    /**
     * @test
     * @dataProvider ambientesValidos
     */
    public function ambienteDeveSerValido($valor)
    {
        $this->object->setAmbiente($valor);
        $this->assertEquals($valor, $this->object->getAmbiente());
    }

    public function ambientesValidos()
    {
        return array(
            array('teste', 'teste'),
            array('produção', 'produção'),
        );
    }

    /**
     * @test
     * @dataProvider ambientesInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaAmbienteInvalido($valor)
    {
        $this->object->setAmbiente($valor);
    }

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
     * @dataProvider idiomasValidos
     */
    public function idiomaDeveSerValido($valor, $expected)
    {
        $this->object->setIdioma($valor);
        
        $this->assertEquals($expected, $this->object->getIdioma());
    }

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
     * @dataProvider idiomasInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaIdiomaInvalido($valor)
    {
        $this->object->setAmbiente($valor);
    }

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
     */
    public function getIdiomasDeveRetornarArray()
    {
        $this->assertTrue(is_array($this->object->getIdiomas()));
    }
    
    /**
     * @test
     */
    public function getAmbientesDeveRetornarArray()
    {
        $this->assertTrue(is_array($this->object->getAmbientes()));
    }
}
