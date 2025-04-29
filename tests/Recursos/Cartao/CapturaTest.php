<?php

namespace MrPrompt\Cielo\Tests\Recursos\Cartao;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use MrPrompt\Cielo\Recursos\Cartao\Captura;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Captura as CapturaDto;
use MrPrompt\Cielo\Tests\TestCase;

class CapturaTest extends TestCase
{
    #[Test]
    #[TestDox('Testa a invocação do método Captura com diferentes cenários de pagamento')]
    #[DataProvider('pagamentoProvider')]
    public function testInvoke(string $id, int $valor, ?int $taxas, string $expectedUrl): void
    {
        $jsonObject = '{"Status":2,"ReasonCode":0,"ReasonMessage":"Successful","ProviderReturnCode":"6","ProviderReturnMessage":"Operation Successful","ReturnCode":"6","ReturnMessage":"Operation Successful","Tid":"0403011945954","ProofOfSale":"825865","AuthorizationCode":"374385","Links":[{"Method":"GET","Rel":"self","Href":"https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/2f9435cc-c7ab-4165-9d68-08f426d3caec"},{"Method":"PUT","Rel":"void","Href":"https://apisandbox.cieloecommerce.cielo.com.br/1/sales/2f9435cc-c7ab-4165-9d68-08f426d3caec/void"}]}';
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        $pagamento = $this->createMock(PagamentoDto::class);
        $pagamento->id = $id;
        $pagamento->valor = $valor;
        $pagamento->taxas = $taxas;

        $httpDriver = $this->createMock(HttpDriver::class);
        $httpDriver
            ->expects($this->once())
            ->method('put')
            ->with($expectedUrl, [])
            ->willReturn($mockResponse);

        $captura = new Captura($httpDriver);
        $response = ($captura)($pagamento);

        $this->assertInstanceOf(CapturaDto::class, $response);
    }

    public static function pagamentoProvider(): array
    {
        return [
            'sem taxas' => [
                'id' => '12345',
                'valor' => 10000,
                'taxas' => null,
                'expectedUrl' => '1/sales/12345/capture?amount=10000',
            ],
            'com taxas' => [
                'id' => '12345',
                'valor' => 10000,
                'taxas' => 500,
                'expectedUrl' => '1/sales/12345/capture?amount=10000&serviceTaxAmount=500',
            ],
        ];
    }
}
