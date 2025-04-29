<?php

namespace MrPrompt\Cielo\Tests\DTO;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Cartao;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Tests\TestCase;

class CartaoTest extends TestCase
{
    #[Test]
    #[DataProvider('cartaoProvider')]
    #[TestDox('Testing Cartao fromRequest with card number $requestData[CardNumber]')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = (object) $requestData;

        $cartao = Cartao::fromRequest($request);

        $this->assertEquals($expectedData['tipo'], $cartao->tipo);
        $this->assertEquals($expectedData['bandeira'], $cartao->bandeira);
        $this->assertEquals($expectedData['numero'], $cartao->numero);
        $this->assertEquals($expectedData['validade'], $cartao->validade);
        $this->assertEquals($expectedData['codigoSeguranca'], $cartao->codigoSeguranca);
        $this->assertEquals($expectedData['portador'], $cartao->portador);
        $this->assertEquals($expectedData['token'], $cartao->token);
    }

    #[Test]
    #[DataProvider('cartaoProvider')]
    #[TestDox('Testing Cartao fromArray with card number $requestData[numero]')]
    public function testFromArray($requestData, $expectedData)
    {
        $modifiedData = $expectedData;
        $modifiedData['tipo'] = $expectedData['tipo']->value;
        $modifiedData['bandeira'] = $expectedData['bandeira']->value;

        $cartao = Cartao::fromArray($modifiedData);

        $this->assertEquals($expectedData['tipo'], $cartao->tipo);
        $this->assertEquals($expectedData['bandeira'], $cartao->bandeira);
        $this->assertEquals($expectedData['numero'], $cartao->numero);
        $this->assertEquals($expectedData['validade'], $cartao->validade);
        $this->assertEquals($expectedData['codigoSeguranca'], $cartao->codigoSeguranca);
        $this->assertEquals($expectedData['portador'], $cartao->portador);
        $this->assertEquals($expectedData['token'], $cartao->token);
    }

    public static function cartaoProvider(): array
    {
        return [
            [
                'requestData' => [
                    'CardType' => TipoCartao::CREDITO->value,
                    'Brand' => Bandeira::VISA->value,
                    'CardNumber' => '1234567890123456',
                    'ExpirationDate' => '12/2025',
                    'SecurityCode' => '123',
                    'Holder' => 'John Doe',
                    'CardToken' => 'token123'
                ],
                'expectedData' => [
                    'tipo' => TipoCartao::CREDITO,
                    'bandeira' => Bandeira::VISA,
                    'numero' => '1234567890123456',
                    'validade' => '12/2025',
                    'codigoSeguranca' => '123',
                    'portador' => 'John Doe',
                    'token' => 'token123'
                ]
            ],
            [
                'requestData' => [
                    'CardType' => TipoCartao::DEBITO->value,
                    'Brand' => Bandeira::MASTERCARD->value,
                    'CardNumber' => '6543210987654321',
                    'ExpirationDate' => '11/2024',
                    'SecurityCode' => '321',
                    'Holder' => 'Jane Doe',
                    'CardToken' => 'token456'
                ],
                'expectedData' => [
                    'tipo' => TipoCartao::DEBITO,
                    'bandeira' => Bandeira::MASTERCARD,
                    'numero' => '6543210987654321',
                    'validade' => '11/2024',
                    'codigoSeguranca' => '321',
                    'portador' => 'Jane Doe',
                    'token' => 'token456'
                ]
            ],
        ];
    }
}
