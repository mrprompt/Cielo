<?php

namespace MrPrompt\Cielo\Tests\Recursos\ZeroAuth;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Recursos\ZeroAuth\Cartao;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\DTO\ZeroAuth as ZeroAuthDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Tests\TestCase;

class CartaoTest extends TestCase
{
    #[Test]
    #[DataProvider('cartaoProvider')]
    #[TestDox('Testing ZeroAuth with card number $numero expects $expectedResult')]
    public function testInvoke(
        $tipo, 
        $bandeira, 
        $numero, 
        $portador, 
        $validade, 
        $codigoSeguranca, 
        $expectedResult
    )
    {
        $jsonObject = json_encode([
            'Brand' => $bandeira->value,
            'CardToken' => null,
            'SaveCard' => false,
        ]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        $mockDriver = $this->createMock(HttpDriver::class);
        $mockDriver->expects($this->once())
                   ->method('post')
                   ->with(
                       $this->equalTo('1/zeroauth/'),
                       $this->equalTo([
                           'CardType' => $tipo->value,
                           'CardNumber' => $numero,
                           'Holder' => $portador,
                           'ExpirationDate' => $validade,
                           'SecurityCode' => $codigoSeguranca,
                           'Brand' => $bandeira->value,
                           
                       ])
                   )
                   ->willReturn($mockResponse);

        $cartaoDto = new CartaoDto(
            tipo: $tipo,
            bandeira: $bandeira,
            numero: $numero,
            validade: $validade,
            codigoSeguranca: $codigoSeguranca,
            portador: $portador
        );

        $cartao = new Cartao($mockDriver);
        $result = $cartao->__invoke($cartaoDto);
        
        $this->assertInstanceOf(ZeroAuthDto::class, $result);
    }

    public static function cartaoProvider()
    {
        return [
            [Tipo::CREDITO, Bandeira::MASTERCARD, '1234567890123456', 'John Doe', '12/2025', '123', 'success'],
            [Tipo::DEBITO, Bandeira::VISA, '6543210987654321', 'Jane Doe', '11/2024', '321', 'success'],
        ];
    }
}
