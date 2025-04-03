<?php

namespace MrPrompt\Cielo\Tests\Enum\Cliente;

use MrPrompt\Cielo\Enum\Cliente\Pais;
use MrPrompt\Cielo\Tests\TestCase;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\DataProvider;

class PaisTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica se o País válido é retornado corretamente')]
    #[DataProvider('validPaisesProvider')]
    public function testValidPaisCase(string $PaisValue, Pais $expectedPais)
    {
        $Pais = Pais::match($PaisValue);
        $this->assertSame($expectedPais, $Pais);
        $this->assertEquals($PaisValue, $Pais->value);
    }

    #[Test]
    #[TestDox('Lança uma exceção ao tentar usar um País inválido')]
    #[DataProvider('invalidPaisesProvider')]
    public function testInvalidPaisThrowsException(string $invalidPais)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("País inválido: $invalidPais");
        Pais::match($invalidPais);
    }

    public static function validPaisesProvider(): array
    {
        return array_map(
            fn($Pais) => [$Pais->value, $Pais],
            Pais::cases()
        );
    }

    public static function invalidPaisesProvider(): array
    {
        return [
            ['XX'],
            ['YY'],
            ['ZZ'],
        ];
    }

    #[Test]
    #[TestDox('Verifica se o método paises retorna um array com os paises válidos')]
    public function testPaisesReturnsArray()
    {
        $this->assertIsArray(Pais::paises());
    }
}
