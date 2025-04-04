<?php

namespace MrPrompt\Cielo\Tests\Recursos\Pix;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use MrPrompt\Cielo\Recursos\Pix\Devolucao;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Devolucao as DevolucaoDto;
use MrPrompt\Cielo\Tests\TestCase;

class DevolucaoTest extends TestCase
{
    #[Test]
    #[TestDox('Testa a invocação do método Devolucao por PaymentId')]
    #[DataProvider('pagamentoProvider')]
    public function testInvoke(string $id, int $valor, string $expectedUrl): void
    {
        $jsonObject = '{"Status":2,"ReturnCode":"6","ReturnMessage":"Operation Successful","Tid":"0403011945954","ProofOfSale":"825865","AuthorizationCode":"374385","Links":[{"Method":"GET","Rel":"self","Href":"https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/2f9435cc-c7ab-4165-9d68-08f426d3caec"},{"Method":"PUT","Rel":"void","Href":"https://apisandbox.cieloecommerce.cielo.com.br/1/sales/2f9435cc-c7ab-4165-9d68-08f426d3caec/void"}]}';
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        $pagamento = $this->createMock(PagamentoDto::class);
        $pagamento->id = $id;
        $pagamento->valor = $valor;

        $httpDriver = $this->createMock(HttpDriver::class);
        $httpDriver
            ->expects($this->once())
            ->method('put')
            ->with($expectedUrl, [])
            ->willReturn($mockResponse);

        $cancelamento = new Devolucao($httpDriver);
        $response = ($cancelamento)($pagamento);

        $this->assertInstanceOf(DevolucaoDto::class, $response);
    }

    public static function pagamentoProvider(): array
    {
        return [
            'sem taxas' => [
                'id' => '12345',
                'valor' => 10000,
                'expectedUrl' => '1/sales/12345/void?amount=10000',
            ],
            'com taxas' => [
                'id' => '12345',
                'valor' => 10000,
                'expectedUrl' => '1/sales/12345/void?amount=10000',
            ],
        ];
    }
}
