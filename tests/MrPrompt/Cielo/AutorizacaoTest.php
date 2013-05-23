<?php
namespace MrPrompt\Cielo;

class AutorizacaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function aoConstruirDeveConfigurarDados()
    {
        $autorizacao = new Autorizacao('teste', 'teste');

        $this->assertEquals('teste', $autorizacao->getNumero());
        $this->assertEquals('teste', $autorizacao->getChave());
    }

    /**
     * @test
     */
    public function deveTruncarNumeroEm20Digitos()
    {
        $autorizacao = new Autorizacao(str_repeat('a', 30), 'teste');

        $this->assertEquals(str_repeat('a', 20), $autorizacao->getNumero());
    }

    /**
     * @test
     */
    public function deveTruncarChaveEm100Digitos()
    {
        $autorizacao = new Autorizacao('teste', str_repeat('a', 130));

        $this->assertEquals(str_repeat('a', 100), $autorizacao->getChave());
    }

    /**
     * @test
     * @dataProvider valoresInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function numeroNaoPodeTerValorInvalido($valor)
    {
        $autorizacao = new Autorizacao($valor, 'teste');
    }

    /**
     * @test
     * @dataProvider valoresInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function chaveNaoPodeTerValorInvalido($valor)
    {
        $autorizacao = new Autorizacao('teste', $valor);
    }

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
}
