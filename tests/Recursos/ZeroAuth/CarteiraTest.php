<?php

namespace MrPrompt\Cielo\Tests\Recursos\ZeroAuth;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Recursos\ZeroAuth\Carteira;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\DTO\Carteira as CarteiraDto;
use MrPrompt\Cielo\DTO\ZeroAuth as ZeroAuthDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Enum\Carteira\Tipo as TipoCarteira;
use MrPrompt\Cielo\Tests\TestCase;

class CarteiraTest extends TestCase
{
    #[Test]
    #[DataProvider('carteiraProvider')]
    #[TestDox('Testing ZeroAuth with wallet and expecting $expectedResult')]
    public function testInvoke($cartaoData, $carteiraData, $expectedResult)
    {
        $jsonObject = json_encode([
            'Brand' => $cartaoData['bandeira']->value,
            'CardToken' => $cartaoData['token'],
            'SaveCard' => false,
        ]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));
        
        $mockDriver = $this->createMock(HttpDriver::class);
        $mockDriver->expects($this->once())
                   ->method('post')
                   ->with(
                       $this->equalTo('2/zeroauth/'),
                       $this->equalTo([
                           'Card' => [
                               'CardType' => $cartaoData['tipo']->value,
                               'CardNumber' => $cartaoData['numero'],
                               'Holder' => $cartaoData['portador'],
                               'ExpirationDate' => $cartaoData['validade'],
                               'SecurityCode' => $cartaoData['codigoSeguranca'],
                               'Brand' => $cartaoData['bandeira']->value,
                               'CardToken' => $cartaoData['token'],
                               
                           ],
                           'Wallet' => [
                               'Type' => $carteiraData['tipo']->value,
                               'Cavv' => $carteiraData['cavv'],
                               'Eci' => $carteiraData['eci'],
                           ],
                       ])
                   )
                   ->willReturn($mockResponse);

        $cartaoDto = new CartaoDto(
            tipo: $cartaoData['tipo'],
            numero: $cartaoData['numero'],
            portador: $cartaoData['portador'],
            validade: $cartaoData['validade'],
            codigoSeguranca: $cartaoData['codigoSeguranca'],
            bandeira: $cartaoData['bandeira'],
            token: $cartaoData['token']
        );

        $carteiraDto = new CarteiraDto(
            tipo: $carteiraData['tipo'],
            cavv: $carteiraData['cavv'],
            eci: $carteiraData['eci']
        );

        $carteira = new Carteira($mockDriver);
        $result = $carteira->__invoke($cartaoDto, $carteiraDto);

        $this->assertInstanceOf(ZeroAuthDto::class, $result);
    }

    public static function carteiraProvider()
    {
        return [
            [
                'cartaoData' => [
                    'tipo' => TipoCartao::CREDITO,
                    'numero' => '1234567890123456',
                    'portador' => 'John Doe',
                    'validade' => '12/2025',
                    'codigoSeguranca' => '123',
                    'bandeira' => Bandeira::VISA,
                    'token' => 'token123'
                ],
                'carteiraData' => [
                    'tipo' => TipoCarteira::APPLE_PAY,
                    'cavv' => 'cavv123',
                    'eci' => 'eci123'
                ],
                'expectedResult' => [

                ]
            ],
            [
                'cartaoData' => [
                    'tipo' => TipoCartao::DEBITO,
                    'numero' => '6543210987654321',
                    'portador' => 'Jane Doe',
                    'validade' => '11/2024',
                    'codigoSeguranca' => '321',
                    'bandeira' => Bandeira::MASTERCARD,
                    'token' => 'token456'
                ],
                'carteiraData' => [
                    'tipo' => TipoCarteira::GOOGLE_PAY,
                    'cavv' => 'cavv456',
                    'eci' => 'eci456'
                ],
                'expectedResult' => 'success'
            ],
        ];
    }
}
