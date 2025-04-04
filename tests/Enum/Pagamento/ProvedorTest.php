<?php

namespace MrPrompt\Cielo\Tests\Enum\Pagamento;

use MrPrompt\Cielo\Enum\Pagamento\Provedor;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\DataProvider;

class ProvedorTest extends TestCase
{
    #[Test]
    #[TestDox('Deve retornar Provedor para o valor $string')]
    #[DataProvider('provedorDataProvider')]
    public function testMatchReturnsCorrectEnumCase(string $input, Provedor $expected): void
    {
        $provedor = Provedor::match($input);
        $this->assertSame($expected, $provedor);
    }

    public static function provedorDataProvider(): array
    {
        return [
            ['Cielo', Provedor::CIELO],
            // Adicione outros casos válidos aqui, se necessário
        ];
    }

    #[Test]
    #[TestDox('Deve lançar uma exceção para um provedor inválido')]
    public function testMatchThrowsExceptionForInvalidProvedor(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Provedor inválido: InvalidProvedor');

        Provedor::match('InvalidProvedor');
    }

    #[Test]
    #[TestDox('Verifica se o método provedores retorna um array com os provedores válidos')]
    public function testProvedoresReturnsArray()
    {
        $this->assertIsArray(Provedor::provedores());
    }
}