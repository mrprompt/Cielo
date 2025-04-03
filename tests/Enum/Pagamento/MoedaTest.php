<?php

namespace MrPrompt\Cielo\Tests\Enum\Pagamento;

use MrPrompt\Cielo\Enum\Pagamento\Moeda;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\DataProvider;

class MoedaTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica o valor do enum PESO_URUGUAIO')]
    public function testPESO_URUGUAIOEnumValue()
    {
        $this->assertSame('UYU', Moeda::PESO_URUGUAIO->value);
    }

    #[Test]
    #[TestDox('Verifica o método match com PESO_URUGUAIO')]
    public function testMatchMethodWithPESO_URUGUAIO()
    {
        $result = Moeda::match('UYU');
        $this->assertSame(Moeda::PESO_URUGUAIO, $result);
    }

    #[Test]
    #[TestDox('Lança exceção para moeda inválida no método match')]
    public function testMatchMethodThrowsExceptionForInvalidCurrency()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Moeda inválida: INVALID');
        Moeda::match('INVALID');
    }

    #[Test]
    #[TestDox('Testa o método match com diferentes moedas')]
    #[DataProvider('currencyProvider')]
    public function testMatchMethodWithDataProvider(string $currency, Moeda $expected)
    {
        $result = Moeda::match($currency);
        $this->assertSame($expected, $result);
    }

    public static function currencyProvider(): array
    {
        return [
            ['UYU', Moeda::PESO_URUGUAIO],
            // Adicione outras moedas aqui, se necessário
        ];
    }

    #[Test]
    #[TestDox('Verifica se o método moedas retorna um array com os moedas válidos')]
    public function testMoedasReturnsArray()
    {
        $this->assertIsArray(Moeda::moedas());
    }
}