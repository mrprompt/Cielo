<?php

namespace MrPrompt\Cielo\Tests\Enum\Cartao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

class BandeiraTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica se o método match retorna o caso correto do enum')]
    public function testMatchReturnsCorrectEnumCase()
    {
        $this->assertSame(Bandeira::VISA, Bandeira::match('Visa'));
        $this->assertSame(Bandeira::MASTERCARD, Bandeira::match('Master'));
        $this->assertSame(Bandeira::ELO, Bandeira::match('Elo'));
        $this->assertSame(Bandeira::AMEX, Bandeira::match('Amex'));
        $this->assertSame(Bandeira::DINERS, Bandeira::match('Diners'));
        $this->assertSame(Bandeira::DISCOVER, Bandeira::match('Discover'));
        $this->assertSame(Bandeira::JCB, Bandeira::match('JCB'));
        $this->assertSame(Bandeira::AURA, Bandeira::match('Aura'));
    }

    #[Test]
    #[TestDox('Verifica se o método match lança uma exceção para valores inválidos')]
    public function testMatchThrowsExceptionForInvalidValue()
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Bandeira inválida: InvalidValue');

        Bandeira::match('InvalidValue');
    }

    #[Test]
    #[TestDox('Verifica se o método bandeiras retorna um array com as bandeira válidas')]
    public function testBandeirasReturnsArray()
    {
        $this->assertIsArray(Bandeira::bandeiras());
    }
}