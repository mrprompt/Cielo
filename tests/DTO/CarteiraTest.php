<?php

namespace MrPrompt\Cielo\Tests\DTO;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Carteira;
use MrPrompt\Cielo\Enum\Carteira\Tipo as TipoCarteira;
use MrPrompt\Cielo\Tests\TestCase;

class CarteiraTest extends TestCase
{
    #[Test]
    #[DataProvider('carteiraProvider')]
    #[TestDox('Testing Carteira fromRequest with cavv $requestData[Cavv] and eci $requestData[Eci]')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = (object) $requestData;

        $carteira = Carteira::fromRequest($request);

        $this->assertEquals($expectedData['tipo'], $carteira->tipo);
        $this->assertEquals($expectedData['cavv'], $carteira->cavv);
        $this->assertEquals($expectedData['eci'], $carteira->eci);
    }

    #[Test]
    #[DataProvider('carteiraProvider')]
    #[TestDox('Testing Carteira fromArray with cavv $requestData[cavv] and eci $requestData[eci]')]
    public function testFromArray($requestData, $expectedData)
    {
        $modifiedData = $expectedData;
        $modifiedData['tipo'] = $expectedData['tipo']->value;

        $carteira = Carteira::fromArray($modifiedData);

        $this->assertEquals($expectedData['tipo'], $carteira->tipo);
        $this->assertEquals($expectedData['cavv'], $carteira->cavv);
        $this->assertEquals($expectedData['eci'], $carteira->eci);
    }

    public static function carteiraProvider(): array
    {
        return [
            [
                'requestData' => [
                    'Type' => TipoCarteira::APPLE_PAY,
                    'Cavv' => 'cavv123',
                    'Eci' => 'eci123'
                ],
                'expectedData' => [
                    'tipo' => TipoCarteira::APPLE_PAY,
                    'cavv' => 'cavv123',
                    'eci' => 'eci123'
                ]
            ],
            [
                'requestData' => [
                    'Type' => TipoCarteira::GOOGLE_PAY,
                    'Cavv' => 'cavv456',
                    'Eci' => 'eci456'
                ],
                'expectedData' => [
                    'tipo' => TipoCarteira::GOOGLE_PAY,
                    'cavv' => 'cavv456',
                    'eci' => 'eci456'
                ]
            ],
            [
                'requestData' => [
                    'Type' => TipoCarteira::SAMSUNG_PAY,
                    'Cavv' => 'cavv456',
                    'Eci' => 'eci456'
                ],
                'expectedData' => [
                    'tipo' => TipoCarteira::SAMSUNG_PAY,
                    'cavv' => 'cavv456',
                    'eci' => 'eci456'
                ]
            ],
        ];
    }
}
