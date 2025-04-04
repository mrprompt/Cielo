<?php

namespace MrPrompt\Cielo\Tests\Enum\Cliente;

use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class StatusTest extends TestCase
{
    #[Test]
    #[TestDox('Deve retornar Status::NOVO para o valor NEW')]
    public function testMatchReturnsNovoForNew(): void
    {
        $status = Status::match('NEW');
        $this->assertSame(Status::NOVO, $status);
    }

    #[Test]
    #[TestDox('Deve retornar Status::EXISTENTE para o valor EXISTING')]
    public function testMatchReturnsExistenteForExisting(): void
    {
        $status = Status::match('EXISTING');
        $this->assertSame(Status::EXISTENTE, $status);
    }

    #[Test]
    #[TestDox('Deve lançar uma exceção para um status inválido')]
    public function testMatchThrowsExceptionForInvalidStatus(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Status de usuário inválido: INVALID');
        Status::match('INVALID');
    }

    #[Test]
    #[TestDox('Deve retornar o status correto para diferentes valores')]
    #[DataProvider('statusProvider')]
    public function testMatchWithDataProvider(string $input, object $expected): void
    {
        $status = Status::match($input);
        $this->assertSame($expected, $status);
    }

    public static function statusProvider(): array
    {
        return [
            ['NEW', Status::NOVO],
            ['EXISTING', Status::EXISTENTE],
        ];
    }

    #[Test]
    #[TestDox('Verifica se o método status retorna um array com os status válidos')]
    public function testStatusReturnsArray()
    {
        $this->assertIsArray(Status::status());
    }
}