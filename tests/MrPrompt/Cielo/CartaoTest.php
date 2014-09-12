<?php
namespace MrPrompt\Cielo;

class CartaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers MrPrompt\Cielo\Cartao::setCartao
     * @covers MrPrompt\Cielo\Cartao::getCartao
     */
    public function numeroDoCartaoDeveSerValido()
    {
        $cartao = new Cartao();
        $cartao->setCartao('4923993827951627');

        $this->assertEquals('4923993827951627', $cartao->getCartao());
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Cartao::setCartao
     * @covers MrPrompt\Cielo\Cartao::getCartao
     */
    public function caracteresNaoNumericosDevemSerRemovidosAoConfigurarOCartao()
    {
        $cartao = new Cartao();
        $cartao->setCartao('4a9a2a3a9a9a3a8aa2a7a9a5a1a6a2a7a');

        $this->assertEquals('4923993827951627', $cartao->getCartao());
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Cartao::setCartao
     * @expectedException InvalidArgumentException
     */
    public function numeroDoCartaoNaoPodeSerVazio()
    {
        $cartao = new Cartao();
        $cartao->setCartao('');
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Cartao::setCartao
     * @expectedException InvalidArgumentException
     */
    public function numeroDoCartaoSerUmNumeroInvalido()
    {
        $cartao = new Cartao();
        $cartao->setCartao('49239938');
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Cartao::setIndicador
     * @covers MrPrompt\Cielo\Cartao::getIndicador
     * @dataProvider indicadoresValidos
     */
    public function indicadorDeCodigoDeSegurancaDeveSerValido($valor)
    {
        $cartao = new Cartao();
        $cartao->setIndicador($valor);

        $this->assertEquals($valor, $cartao->getIndicador());
    }

    /**
     * data provider
     * 
     * @return array
     */
    public function indicadoresValidos()
    {
        return array(
            array(0),
            array(1),
            array(2),
            array(9)
        );
    }

    /**
     * @test
     * @covers MrPrompt\Cielo\Cartao::setIndicador
     * @dataProvider indicadoresInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaIndicadorInvalido($valor)
    {
        $cartao = new Cartao();
        $cartao->setIndicador($valor);
    }

    public function indicadoresInvalidos()
    {
        return array(
            array(3),
            array(-1),
            array(null),
            array('d'),
            array(array('d')),
            array((object) array('d' => 'asdad')),
        );
    }

    /**
     * @test
     */
    public function codigoDeSegurancaDeveSerNumerico()
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca(123);

        $this->assertEquals(123, $cartao->getCodigoSeguranca());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function codigoDeSegurancaNaoPodeConterCaracteresAlfabeticos()
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca('aaa');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function codigoDeSegurancaNaoPodeConterPontuacao()
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca('22.');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function codigoDeSegurancaNaoPodeConterEspacos()
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca('22 2');
    }

    /**
     * @test
     */
    public function nomePortadorDeveSerAlfanumerico()
    {
        $cartao = new Cartao();
        $cartao->setNomePortador('Thiago Paes 1000');

        $this->assertEquals('Thiago Paes 1000', $cartao->getNomePortador());
    }

    /**
     * @test
     */
    public function nomePortadorDeveSerTruncadoEm50Caracteres()
    {
        $cartao = new Cartao();
        $cartao->setNomePortador(str_repeat('a', 60));

        $this->assertEquals(str_repeat('a', 50), $cartao->getNomePortador());
    }

    /**
     * @test
     * @dataProvider nomesInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function nomePortadorNaoPodeSerInvalido($valor)
    {
        $cartao = new Cartao();
        $cartao->setNomePortador($valor);
    }

    public function nomesInvalidos()
    {
        return array(
            array(null),
            array(''),
            array(array('djkhkdh')),
            array((object) array('aa' => 'dsfsdff'))
        );
    }

    /**
     * @test
     */
    public function validadeDeveSerInformadaNoFormatoCorreto()
    {
        $cartao = new Cartao();
        $cartao->setValidade('201606', '201302');

        $this->assertEquals('201606', $cartao->getValidade());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function validadeNaoPodeConterCaracteresAlfabeticos()
    {
        $cartao = new Cartao();
        $cartao->setValidade('aaa');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function validadeNaoPodeConterPontuacao()
    {
        $cartao = new Cartao();
        $cartao->setValidade('22.');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function validadeNaoPodeConterEspacos()
    {
        $cartao = new Cartao();
        $cartao->setValidade('22 2');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function naoPodeSerUtilizadaValidadeNoPassado()
    {
        $cartao = new Cartao();
        $cartao->setValidade('201210', '201305');
    }

    /**
     * @test
     */
    public function bandeiraDeveSerValido()
    {
        $cartao = new Cartao();
        $cartao->setBandeira('visa');

        $this->assertEquals('visa', $cartao->getBandeira());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function bandeiraDeveReceberApenasMinusculos()
    {
        $cartao = new Cartao();
        $cartao->setBandeira('MASTERCARD');

        $this->assertEquals('mastercard', $cartao->getBandeira());
    }

    /**
     * @test
     * @dataProvider bandeirasInvalidas
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaBandeiraInvalido($valor)
    {
        $cartao = new Cartao();
        $cartao->setBandeira($valor);
    }

    public function bandeirasInvalidas()
    {
        return array(
            array(3),
            array(-1),
            array(null),
            array('d'),
            array(array('d')),
            array((object) array('d' => 'ADSFS')),
        );
    }
}
