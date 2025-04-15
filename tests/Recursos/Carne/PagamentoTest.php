<?php

namespace MrPrompt\Cielo\Tests\Recursos\Carne;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Cartao\Tipo as CartaoTipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as CartaoBandeira;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Recursos\Carne\Pagamento;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

class PagamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('invokeProvider')]
    #[TestDox('Testing Carnê payment method')]
    public function testInvoke($ordemMock, $clienteMock, $pagamentoMock, $expectedStatus)
    {
        $jsonObject = <<<EOF
{
  "MerchantOrderId": "Loja123456",
  "Customer": {
    "Name": "Comprador Carnet simples"
  },
  "Payment": {
    "DebitCard": {
      "CardNumber": "520799******5567",
      "Holder": "Test Holder",
      "ExpirationDate": "02/2026",
      "SaveCard": false,
      "Brand": "Visa"
    },
    "Provider": "Simulado",
    "SoftDescriptor": "123456789ABCD",
    "Tid": "0415083134901",
    "Authenticate": true,
    "Recurrent": false,
    "Amount": 1000,
    "ReceivedDate": "2025-04-15 08:31:34",
    "Status": 3,
    "IsSplitted": false,
    "ReturnMessage": "Card Canceled",
    "ReturnCode": "77",
    "PaymentId": "65e1ab79-4a22-4a3a-9293-251b4f315e6f",
    "Type": "DebitCard",
    "Currency": "BRL",
    "Country": "BRA",
    "Links": [
      {
        "Method": "GET",
        "Rel": "self",
        "Href": "https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/65e1ab79-4a22-4a3a-9293-251b4f315e6f"
      }
    ]
  }
}
EOF;

        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject, 'r')));

        $httpDriverMock = $this->createMock(HttpDriver::class);
        $httpDriverMock->expects($this->once())
            ->method('post')
            ->with(
                '1/sales/',
                $this->callback(function ($dadosPagamento) use ($ordemMock, $clienteMock, $pagamentoMock) {
                    return $dadosPagamento['MerchantOrderId'] === $ordemMock->identificador &&
                        $dadosPagamento['Customer']['Name'] === $clienteMock->nome &&
                        $dadosPagamento['Payment']['Amount'] === $pagamentoMock->valor;
                })
            )
            ->willReturn($mockResponse);

        $pagamento = new Pagamento($httpDriverMock);
        $response = $pagamento($ordemMock, $clienteMock, $pagamentoMock);

        $this->assertInstanceOf(TransacaoDto::class, $response);
    }

    public static function invokeProvider(): array
    {
        $ordemMock1 = new OrdemDto('Loja123456');

        $clienteMock1 = ClienteDto::fromArray([
            'nome' => 'Comprador Carnet simples',
        ]);

        $pagamentoMock1 = PagamentoDto::fromArray([
            'tipo' => PagamentoTipo::CARTAO_DE_DEBITO->value,
            'descricao' => 'Pagamento de Carnê',
            'valor' => 1000,
            'provedor' => ProvedorTipo::BANCO_DO_BRASIL->value,
            'parcelas' => 10,
            'cartao' => [
                'tipo' => CartaoTipo::DEBITO->value,
                'bandeira' => CartaoBandeira::VISA->value,
                'numero' => '5207992865485567',
                'validade' => '02/2026',
                'codigoSeguranca' => '835',
                'portador' => 'Test Holder',
            ],
        ]);

        return [
            [$ordemMock1, $clienteMock1, $pagamentoMock1, 'success'],
        ];
    }
}
