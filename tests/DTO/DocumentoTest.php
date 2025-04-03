<?php

namespace MrPrompt\Cielo\Tests\DTO;

use MrPrompt\Cielo\DTO\Documento;
use MrPrompt\Cielo\Enum\Cliente\Documento as DocumentoTipo;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class DocumentoTest extends TestCase
{
    #[Test]
    #[TestDox('Test from request with identity type and identity')]
    #[DataProvider('requestDataProvider')]
    public function testFromRequest($identityType, $identity, $expectedTipo, $expectedNumero)
    {
        $request = new \stdClass();
        $request->IdentityType = $identityType;
        $request->Identity = $identity;

        $documento = Documento::fromRequest($request);

        $this->assertInstanceOf(Documento::class, $documento);
        $this->assertEquals($expectedTipo, $documento->tipo);
        $this->assertEquals($expectedNumero, $documento->numero);
    }

    public static function requestDataProvider()
    {
        return [
            ['CPF', '12345678909', DocumentoTipo::match('CPF'), '12345678909'],
        ];
    }

    #[Test]
    #[TestDox('Test from array with data')]
    #[DataProvider('arrayDataProvider')]
    public function testFromArray($data, $expectedTipo, $expectedNumero)
    {
        $documento = Documento::fromArray($data);

        $this->assertInstanceOf(Documento::class, $documento);
        $this->assertEquals($expectedTipo, $documento->tipo);
        $this->assertEquals($expectedNumero, $documento->numero);
    }

    public static function arrayDataProvider()
    {
        return [
            [
                [
                    'tipo' => 'CNPJ', 
                    'numero' => '12345678000195'
                ], 
                DocumentoTipo::match('CNPJ'), 
                '12345678000195'
            ],
        ];
    }
}
