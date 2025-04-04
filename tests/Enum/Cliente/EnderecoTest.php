<?php

namespace MrPrompt\Cielo\Tests\Enum\Cliente;

use MrPrompt\Cielo\Enum\Cliente\Endereco;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class EnderecoTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica se match retorna o caso correto do enum')]
    public function testMatchReturnsCorrectEnumCase()
    {
        $this->assertSame(Endereco::RESIDENCIAL, Endereco::match('Address'));
    }

    #[Test]
    #[TestDox('Verifica se match lança exceção para um valor inválido')]
    public function testMatchThrowsExceptionForInvalidValue()
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Tipo de endereço inválido: Invalido');
        Endereco::match('Invalido');
    }

    #[Test]
    #[TestDox('Verifica se o método endereços retorna um array com os endereços válidos')]
    public function testBandeirasReturnsArray()
    {
        $this->assertIsArray(Endereco::enderecos());
    }
}