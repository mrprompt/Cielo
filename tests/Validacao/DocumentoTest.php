<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Validacao\Documento;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\DTO\Documento as DocumentoDto;

class DocumentoTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid document')]
    public function testValidatePassesForValidDocumento(): void
    {
        $documento = DocumentoDto::fromArray([
            'numero' => '12345678900',
            'tipo' => 'CPF'
        ]);

        $result = Documento::validate($documento);

        $this->assertTrue($result);
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid document')]
    public function testValidateThrowsExceptionForInvalidDocumento(): void
    {
        $this->expectException(ValidacaoErrors::class);

        $documento = DocumentoDto::fromArray([
            'numero' => 'aaaaa',
            'tipo' => 'CPF'
        ]);

        $result = Documento::validate($documento);
        var_dump($result);
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid document')]
    public function testValidateThrowsExceptionForInvalidType(): void
    {
        $this->expectException(ValidacaoErrors::class);

        $documento = DocumentoDto::fromArray([
            'numero' => '12345678900',
            'tipo' => ''
        ]);

        Documento::validate($documento);
    }
}
