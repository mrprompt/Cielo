<?php

namespace MrPrompt\Cielo\Tests\Recursos\ZeroAuth;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Recursos\ZeroAuth\Token;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\DTO\ZeroAuth as ZeroAuthDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Tests\TestCase;

class TokenTest extends TestCase
{
    #[Test]
    #[DataProvider('cartaoProvider')]
    #[TestDox('Testing ZeroAuth with card token $token expects $expectedResult')]
    public function testInvoke(
        $tipo, 
        $bandeira, 
        $token, 
        $expectedResult
    )
    {
        $jsonObject = json_encode([
            'Brand' => $bandeira->value,
            'CardToken' => $token,
            'SaveCard' => false,
        ]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        // Cria um mock do HttpDriver
        $mockDriver = $this->createMock(HttpDriver::class);

        // Define o comportamento esperado do método post do driver
        $mockDriver->expects($this->once())
                   ->method('post')
                   ->with(
                       $this->equalTo('1/zeroauth/'),
                       $this->equalTo([
                           'Brand' => $bandeira->value,
                           'CardToken' => $token,
                           'SaveCard' => false,
                       ])
                   )
                   ->willReturn($mockResponse);

        // Cria uma instância do CartaoDto com dados de exemplo
        $cartaoDto = new CartaoDto(
            tipo: $tipo,
            bandeira: $bandeira,
            token: $token
        );

        // Instancia a classe Token com o mock do driver
        $cartao = new Token($mockDriver);

        // Chama o método __invoke e verifica o resultado
        $result = $cartao->__invoke($cartaoDto);
        $this->assertInstanceOf(ZeroAuthDto::class, $result);
    }

    public static function cartaoProvider()
    {
        return [
            [Tipo::CREDITO, Bandeira::MASTERCARD, '23712c39-bb08-4030-86b3-490a223a8cc9', 'success'],
            [Tipo::DEBITO, Bandeira::VISA, '23712c39-bb09-5031-96b4-590a223a8dc0', 'success'],
        ];
    }
}
