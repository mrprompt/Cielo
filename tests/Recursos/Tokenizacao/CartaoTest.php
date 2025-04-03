<?php

namespace MrPrompt\Cielo\Tests\Recursos\Tokenizacao;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Recursos\Tokenizacao\Cartao;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Tests\TestCase;

class CartaoTest extends TestCase
{
    #[Test]
    #[DataProvider('cartaoProvider')]
    #[TestDox('Testing Tokenizacao with card number $numero expects $expectedResult')]
    public function testInvoke(
        $tipo,
        $nome, 
        $numero, 
        $portador, 
        $validade, 
        $bandeira, 
        $expectedResult
    )
    {
        $jsonObject = json_encode([
            'Brand' => $bandeira->value,
        ]);
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        $mockDriver = $this->createMock(HttpDriver::class);
        $mockDriver->expects($this->once())
                   ->method('post')
                   ->with(
                       $this->equalTo('1/card/'),
                       $this->equalTo([
                           'CustomerName' => $nome,
                           'CardNumber' => $numero,
                           'Holder' => $portador,
                           'ExpirationDate' => $validade,
                           'Brand' => $bandeira->value,
                           'CardType' => $tipo->value,
                           
                       ])
                   )
                   ->willReturn($mockResponse);

        $cartaoDto = new CartaoDto(
            tipo: $tipo,
            bandeira: $bandeira,
            nome: $nome,
            numero: $numero,
            validade: $validade,
            portador: $portador
        );

        $cartao = new Cartao($mockDriver);
        $result = $cartao->__invoke($cartaoDto);
       
        $this->assertInstanceOf(CartaoDto::class, $result);
    }

    public static function cartaoProvider()
    {
        return [
            [Tipo::CREDITO, 'John Doe', '1234567890123456', 'John Doe', '12/2025', Bandeira::MASTERCARD, 'success'],
            [Tipo::CREDITO, 'Jane Doe', '6543210987654321', 'Jane Doe', '11/2024', Bandeira::VISA, 'success'],
        ];
    }
}
