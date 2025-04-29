<?php

namespace MrPrompt\Cielo\Tests\DTO;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Ordem;
use MrPrompt\Cielo\Tests\TestCase;

class OrdemTest extends TestCase
{
    #[Test]
    #[DataProvider('ordemProvider')]
    #[TestDox('Testing Ordem fromRequest with MerchantOrderId $requestData[MerchantOrderId]')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = (object) $requestData;

        $ordem = Ordem::fromRequest($request);

        $this->assertEquals($expectedData['identificador'], $ordem->identificador);
    }

    #[Test]
    #[DataProvider('ordemProvider')]
    #[TestDox('Testing Ordem fromArray with MerchantOrderId $requestData[MerchantOrderId]')]
    public function testFromArray($requestData, $expectedData)
    {
        $ordem = Ordem::fromArray($expectedData);

        $this->assertEquals($expectedData['identificador'], $ordem->identificador);
    }

    public static function ordemProvider(): array
    {
        return [
            [
                'requestData' => [
                    'MerchantOrderId' => '123456'
                ],
                'expectedData' => [
                    'identificador' => '123456'
                ]
            ],
            [
                'requestData' => [
                    'MerchantOrderId' => '654321'
                ],
                'expectedData' => [
                    'identificador' => '654321'
                ]
            ],
        ];
    }
}