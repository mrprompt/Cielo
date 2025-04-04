<?php

namespace MrPrompt\Cielo\Tests\Enum\Cliente;

use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\DataProvider;

class EstadoTest extends TestCase
{
    #[Test]
    #[TestDox('Verifica se o estado válido é retornado corretamente')]
    #[DataProvider('validEstadosProvider')]
    public function testValidEstadoCase(string $estadoValue, Estado $expectedEstado)
    {
        $estado = Estado::match($estadoValue);
        $this->assertSame($expectedEstado, $estado);
        $this->assertEquals($estadoValue, $estado->value);
    }

    #[Test]
    #[TestDox('Lança uma exceção ao tentar usar um estado inválido')]
    #[DataProvider('invalidEstadosProvider')]
    public function testInvalidEstadoThrowsException(string $invalidEstado)
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage("Estado inválido: $invalidEstado");
        Estado::match($invalidEstado);
    }

    public static function validEstadosProvider(): array
    {
        return array_map(
            fn($estado) => [$estado->value, $estado],
            Estado::cases()
        );
    }

    public static function invalidEstadosProvider(): array
    {
        return [
            ['XX'],
            ['YY'],
            ['ZZ'],
        ];
    }

    #[Test]
    #[TestDox('Verifica se o método estados retorna um array com os estados válidos')]
    public function testEstadosReturnsArray()
    {
        $this->assertIsArray(Estado::estados());
    }
}
