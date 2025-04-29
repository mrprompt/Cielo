<?php

namespace MrPrompt\Cielo\Tests\Enum\Cliente;

use MrPrompt\Cielo\Enum\Cliente\Documento;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class DocumentoTest extends TestCase
{
    #[Test]
    #[TestDox('Retorna CPF para um tipo válido de CPF')]
    public function testMatchReturnsCPFForValidCPFType(): void
    {
        $result = Documento::match('CPF');
        $this->assertSame(Documento::CPF, $result);
    }

    #[Test]
    #[TestDox('Retorna CNPJ para um tipo válido de CNPJ')]
    public function testMatchReturnsCNPJForValidCNPJType(): void
    {
        $result = Documento::match('CNPJ');
        $this->assertSame(Documento::CNPJ, $result);
    }

    #[Test]
    #[TestDox('Lança exceção para um tipo de documento inválido')]
    public function testMatchThrowsExceptionForInvalidType(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Tipo de documento inválido: INVALID');

        Documento::match('INVALID');
    }

    #[Test]
    #[TestDox('Verifica se o método documentos retorna um array com os tipos válidos')]
    public function testDocumentosReturnsArray()
    {
        $this->assertIsArray(Documento::documentos());
    }
}