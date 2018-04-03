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

namespace MrPrompt\Cielo\Tests;

use MrPrompt\Cielo\Cartao;
use ReflectionProperty;
use PHPUnit\Framework\TestCase;

/**
 * Class CartaoTest
 * @package MrPrompt\Cielo\Tests
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class CartaoTest extends TestCase
{
    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::getCartao
     */
    public function proprieadadeComNumeroDoCartaoNaoPodeSerModificado(): void
    {
        $cartao = new Cartao();

        $reflection = new \ReflectionProperty(Cartao::class, 'cartao');
        $reflection->setAccessible(true);
        $reflection->setValue($cartao, 'Elo');

        $this->assertEquals('Elo', $cartao->getCartao());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCartao
     * @covers \MrPrompt\Cielo\Cartao::getCartao
     */
    public function numeroDoCartaoDeveSerValido(): void
    {
        $cartao = new Cartao();
        $cartao->setCartao('4923993827951627');

        $this->assertEquals('4923993827951627', $cartao->getCartao());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCartao
     * @covers \MrPrompt\Cielo\Cartao::getCartao
     */
    public function caracteresNaoNumericosDevemSerRemovidosAoConfigurarOCartao(): void
    {
        $cartao = new Cartao();
        $cartao->setCartao('4a9a2a3a9a9a3a8aa2a7a9a5a1a6a2a7a');

        $this->assertEquals('4923993827951627', $cartao->getCartao());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCartao
     * @expectedException InvalidArgumentException
     */
    public function numeroDoCartaoNaoPodeSerVazio(): void
    {
        $cartao = new Cartao();
        $cartao->setCartao('');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCartao
     * @expectedException InvalidArgumentException
     */
    public function numeroDoCartaoSerUmNumeroInvalido(): void
    {
        $cartao = new Cartao();
        $cartao->setCartao('49239938');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::getIndicador
     */
    public function indicadorDeCodigoDeSegurancaDeveRetornarValorDaPropriedadeIndicador(): void
    {
        $cartao = new Cartao();

        $reflection = new \ReflectionProperty(Cartao::class, 'indicador');
        $reflection->setAccessible(true);
        $reflection->setValue($cartao, 1);

        $this->assertEquals(1, $cartao->getIndicador());
    }

    /**
     * @test
     * @covers       \MrPrompt\Cielo\Cartao::setIndicador
     * @covers       \MrPrompt\Cielo\Cartao::getIndicador
     * @dataProvider indicadoresValidos
     */
    public function indicadorDeCodigoDeSegurancaDeveSerValido($valor): void
    {
        $cartao = new Cartao();
        $cartao->setIndicador($valor);

        $this->assertEquals($valor, $cartao->getIndicador());
    }

    /**
     * data provider
     * @return array
     */
    public function indicadoresValidos(): array
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
     * @covers       \MrPrompt\Cielo\Cartao::setIndicador
     * @dataProvider indicadoresInvalidos
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaIndicadorInvalido($valor): void
    {
        $cartao = new Cartao();
        $cartao->setIndicador($valor);
    }

    /**
     * Data provider
     * @return array
     */
    public function indicadoresInvalidos(): array
    {
        return array(
            array(3),
            array(-1),
            array(null),
            array('d'),
            array(array('d')),
            array((object)array('d' => 'asdad')),
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::getCodigoSeguranca
     */
    public function codigoSegurancaDeveRetornarPropriedadeCodigoSeguranca(): void
    {
        $cartao = new Cartao();

        $reflection = new \ReflectionProperty(Cartao::class, 'codigoSeguranca');
        $reflection->setAccessible(true);
        $reflection->setValue($cartao, '1');

        $this->assertEquals('1', $cartao->getCodigoSeguranca());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCodigoSeguranca
     * @covers \MrPrompt\Cielo\Cartao::getCodigoSeguranca
     */
    public function codigoDeSegurancaDeveSerNumerico(): void
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca(123);

        $this->assertEquals(123, $cartao->getCodigoSeguranca());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCodigoSeguranca
     * @expectedException \InvalidArgumentException
     */
    public function codigoDeSegurancaNaoPodeConterCaracteresAlfabeticos(): void
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca('aaa');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCodigoSeguranca
     * @expectedException \InvalidArgumentException
     */
    public function codigoDeSegurancaNaoPodeConterPontuacao(): void
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca('22.');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setCodigoSeguranca
     * @expectedException \InvalidArgumentException
     */
    public function codigoDeSegurancaNaoPodeConterEspacos(): void
    {
        $cartao = new Cartao();
        $cartao->setCodigoSeguranca('22 2');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setNomePortador
     * @covers \MrPrompt\Cielo\Cartao::getNomePortador
     */
    public function nomePortadorDeveSerAlfanumerico(): void
    {
        $cartao = new Cartao();
        $cartao->setNomePortador('Thiago Paes 1000');

        $this->assertEquals('Thiago Paes 1000', $cartao->getNomePortador());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setNomePortador
     * @covers \MrPrompt\Cielo\Cartao::getNomePortador
     */
    public function nomePortadorDeveSerTruncadoEm50Caracteres(): void
    {
        $cartao = new Cartao();
        $cartao->setNomePortador(str_repeat('a', 60));

        $this->assertEquals(str_repeat('a', 50), $cartao->getNomePortador());
    }

    /**
     * @test
     * @dataProvider nomesInvalidos
     * @covers \MrPrompt\Cielo\Cartao::setNomePortador
     * @expectedException \InvalidArgumentException
     */
    public function nomePortadorNaoPodeSerInvalido($valor): void
    {
        $cartao = new Cartao();
        $cartao->setNomePortador($valor);
    }

    /**
     * Data provider
     * @return array
     */
    public function nomesInvalidos(): array
    {
        return array(
            array(null),
            array(''),
            array(array('djkhkdh')),
            array((object)array('aa' => 'dsfsdff'))
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setValidade
     * @covers \MrPrompt\Cielo\Cartao::getValidade
     */
    public function validadeDeveSerInformadaNoFormatoCorreto(): void
    {
        $cartao = new Cartao();
        $cartao->setValidade('201606', '201302');

        $this->assertEquals('201606', $cartao->getValidade());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setValidade
     * @expectedException \InvalidArgumentException
     */
    public function validadeNaoPodeConterCaracteresAlfabeticos(): void
    {
        $cartao = new Cartao();
        $cartao->setValidade('aaa');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setValidade
     * @expectedException \InvalidArgumentException
     */
    public function validadeNaoPodeConterPontuacao(): void
    {
        $cartao = new Cartao();
        $cartao->setValidade('22.');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setValidade
     * @expectedException \InvalidArgumentException
     */
    public function validadeNaoPodeConterEspacos(): void
    {
        $cartao = new Cartao();
        $cartao->setValidade('22 2');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setValidade
     * @expectedException \InvalidArgumentException
     */
    public function naoPodeSerUtilizadaValidadeNoPassado(): void
    {
        $cartao = new Cartao();
        $cartao->setValidade('201210', '201305');
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setBandeira
     * @covers \MrPrompt\Cielo\Cartao::getBandeira
     */
    public function bandeiraDeveSerValido(): void
    {
        $cartao = new Cartao();
        $cartao->setBandeira('visa');

        $this->assertEquals('visa', $cartao->getBandeira());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setBandeira
     * @covers \MrPrompt\Cielo\Cartao::getBandeira
     * @expectedException \InvalidArgumentException
     */
    public function bandeiraDeveReceberApenasMinusculos(): void
    {
        $cartao = new Cartao();
        $cartao->setBandeira('MASTERCARD');

        $this->assertEquals('mastercard', $cartao->getBandeira());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setBandeira
     * @dataProvider bandeirasInvalidas
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarErroCasoRecebaBandeiraInvalido($valor): void
    {
        $cartao = new Cartao();
        $cartao->setBandeira($valor);
    }

    /**
     * Data provider
     * @return array
     */
    public function bandeirasInvalidas(): array
    {
        return array(
            array(3),
            array(-1),
            array(null),
            array('d'),
            array(array('d')),
            array((object)array('d' => 'ADSFS')),
        );
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::getBandeiras
     */
    public function listarBandeirasDeveRetornarUmArray(): void
    {
        $cartao = new Cartao();
        $bandeiras = $cartao->getBandeiras();

        $this->assertTrue(is_array($bandeiras));
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::getToken
     */
    public function getTokenDeveRetornarPropriedadeTokenInalterada(): void
    {
        $cartao = new Cartao();

        $reflection = new \ReflectionProperty(Cartao::class, 'token');
        $reflection->setAccessible(true);
        $reflection->setValue($cartao, 'fooo');

        $this->assertEquals('fooo', $cartao->getToken());
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::setToken
     */
    public function setTokenDeveRetornarValorDoTokenInalterado(): void
    {
        $cartao = new Cartao();
        $token  = $cartao->setToken('fooo');

        $this->assertEquals('fooo', $token);
    }

    /**
     * @test
     * @covers \MrPrompt\Cielo\Cartao::hasToken
     */
    public function hasTokenDeveRetornarTrueSeTokenEstiverDefinido(): void
    {
        $cartao = new Cartao();

        $reflection = new \ReflectionProperty(Cartao::class, 'token');
        $reflection->setAccessible(true);
        $reflection->setValue($cartao, 'fooo');

        $this->assertTrue($cartao->hasToken());
    }
}
