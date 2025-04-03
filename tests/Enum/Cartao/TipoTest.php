<?php

namespace MrPrompt\Cielo\Tests\Enum\Cartao;

use MrPrompt\Cielo\Enum\Cartao\Tipo;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class TipoTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica se match retorna CREDITO para CreditCard')]
    public function testMatchReturnsCreditoForCreditCard(): void
    {
        $result = Tipo::match('CreditCard');
        $this->assertSame(Tipo::CREDITO, $result);
    }

    #[Test]
    #[TestDox('Verifica se match retorna DEBITO para DebitCard')]
    public function testMatchReturnsDebitoForDebitCard(): void
    {
        $result = Tipo::match('DebitCard');
        $this->assertSame(Tipo::DEBITO, $result);
    }

    #[Test]
    #[TestDox('Verifica se match lança exceção para um valor inválido')]
    public function testMatchThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de cartão inválido: InvalidCard');
        Tipo::match('InvalidCard');
    }

    #[Test]
    #[TestDox('Verifica se o método tipos retorna um array com os tipos válidos')]
    public function testTiposReturnsArray()
    {
        $this->assertIsArray(Tipo::tipos());
    }
}
