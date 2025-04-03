<?php

namespace MrPrompt\Cielo\Tests\Recursos\Cartao;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use MrPrompt\Cielo\Recursos\Cartao\CancelamentoMerchantOrderId;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cancelamento as CancelamentoDto;
use MrPrompt\Cielo\Tests\TestCase;

class CancelamentoMerchantOrderIdTest extends TestCase
{
    #[Test]
    #[TestDox('Testa a invocação do método Cancelamento por MerchantOrderId')]
    #[DataProvider('pagamentoProvider')]
    public function testInvoke(string $identificador, string $id, int $valor, string $expectedUrl): void
    {
        $jsonObject = '{"Status":2,"ReturnCode":"6","ReturnMessage":"Operation Successful","Tid":"0403011945954","ProofOfSale":"825865","AuthorizationCode":"374385","Links":[{"Method":"GET","Rel":"self","Href":"https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/2f9435cc-c7ab-4165-9d68-08f426d3caec"},{"Method":"PUT","Rel":"void","Href":"https://apisandbox.cieloecommerce.cielo.com.br/1/sales/2f9435cc-c7ab-4165-9d68-08f426d3caec/void"}]}';
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        $ordem = $this->getMockBuilder(OrdemDto::class)
                    ->setConstructorArgs([$identificador])
                    ->getMock();

        $pagamento = $this->createMock(PagamentoDto::class);
        $pagamento->id = $id;
        $pagamento->valor = $valor;

        $httpDriver = $this->createMock(HttpDriver::class);
        $httpDriver
            ->expects($this->once())
            ->method('put')
            ->with($expectedUrl, [])
            ->willReturn($mockResponse);

        $cancelamento = new CancelamentoMerchantOrderId($httpDriver);
        $response = ($cancelamento)($ordem, $pagamento);

        $this->assertInstanceOf(CancelamentoDto::class, $response);
    }

    public static function pagamentoProvider(): array
    {
        return [
            'identicador como digitos' => [
                'identificador' => '0102030405',
                'id' => '12345',
                'valor' => 10000,
                'expectedUrl' => '1/sales/OrderId/0102030405/void?amount=10000',
            ],
        ];
    }
}
