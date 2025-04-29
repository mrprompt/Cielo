<?php

namespace MrPrompt\Cielo\Tests\Enum\Carteira;

use MrPrompt\Cielo\Enum\Carteira\Tipo;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class TipoTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica se match retorna APPLE_PAY para ApplePay')]
    public function testMatchReturnsApplePayForApplePay(): void
    {
        $result = Tipo::match('ApplePay');
        $this->assertSame(Tipo::APPLE_PAY, $result);
    }

    #[Test]
    #[TestDox('Verifica se match retorna GOOGLE_PAY para GooglePay')]
    public function testMatchReturnsGooglePayForGooglePay(): void
    {
        $result = Tipo::match('GooglePay');
        $this->assertSame(Tipo::GOOGLE_PAY, $result);
    }

    #[Test]
    #[TestDox('Verifica se match retorna SAMSUNG_PAY para SamsungPay')]
    public function testMatchReturnsSamsungPayForSamsungPay(): void
    {
        $result = Tipo::match('SamsungPay');
        $this->assertSame(Tipo::SAMSUNG_PAY, $result);
    }

    #[Test]
    #[TestDox('Verifica se match lança exceção para um valor inválido')]
    public function testMatchThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Tipo de carteira inválida: InvalidWallet');
        Tipo::match('InvalidWallet');
    }

    #[Test]
    #[TestDox('Verifica se o método carteiras retorna um array com os tipos válidos')]
    public function testCarteirasReturnsArray()
    {
        $this->assertIsArray(Tipo::carteiras());
    }
}
