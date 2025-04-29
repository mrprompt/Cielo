<?php

namespace MrPrompt\Cielo\Tests\Recursos\Click2Pay;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\DTO\Carteira as CarteiraDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Cliente\Status as ClienteStatus;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Enum\Carteira\Tipo as CarteiraTipo;
use MrPrompt\Cielo\Recursos\Click2Pay\Pagamento;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

class PagamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('invokeProvider')]
    #[TestDox('Testing Click2Pay payment method')]
    public function testInvoke($ordemMock, $clienteMock, $pagamentoMock, $carteiraMock1, $expectedStatus)
    {
        $jsonObject = <<<EOF
{
  "MerchantOrderId": "123456",
  "Customer": {
    "Name": "safasfs"
  },
  "Payment": {
    "ServiceTaxAmount": 0,
    "Installments": 1,
    "Interest": 0,
    "Capture": false,
    "Authenticate": false,
    "Recurrent": false,
    "CreditCard": {
      "CardNumber": "************1234",
      "Holder": "Cielo",
      "ExpirationDate": "12/2030",
      "SaveCard": false,
      "Brand": "Master",
      "PaymentAccountReference": "YMYK208HEOOSVNZWC13U1DZZ9GLZP"
    },
    "Tid": "0415023444669",
    "ProofOfSale": "093315",
    "AuthorizationCode": "728038",
    "Provider": "Simulado",
    "IsQrCode": false,
    "Amount": 1000,
    "ReceivedDate": "2025-04-15 02:34:44",
    "Status": 1,
    "IsSplitted": false,
    "ReturnMessage": "Operation Successful",
    "ReturnCode": "4",
    "PaymentId": "15b2b80d-1a5e-49c6-bb93-4dbd5a2813a4",
    "Type": "CreditCard",
    "Currency": "BRL",
    "Country": "BRA",
    "Links": [
      {
        "Method": "GET",
        "Rel": "self",
        "Href": "https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/15b2b80d-1a5e-49c6-bb93-4dbd5a2813a4"
      },
      {
        "Method": "PUT",
        "Rel": "capture",
        "Href": "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/15b2b80d-1a5e-49c6-bb93-4dbd5a2813a4/capture"
      },
      {
        "Method": "PUT",
        "Rel": "void",
        "Href": "https://apisandbox.cieloecommerce.cielo.com.br/1/sales/15b2b80d-1a5e-49c6-bb93-4dbd5a2813a4/void"
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
                '1/sales',
                $this->callback(function ($dadosPagamento) use ($ordemMock, $clienteMock, $pagamentoMock, $carteiraMock1) {
                    return $dadosPagamento['MerchantOrderId'] === $ordemMock->identificador &&
                        $dadosPagamento['Customer']['Name'] === $clienteMock->nome &&
                        $dadosPagamento['Payment']['Amount'] === $pagamentoMock->valor;
                })
            )
            ->willReturn($mockResponse);

        $pagamento = new Pagamento($httpDriverMock);
        $response = $pagamento($ordemMock, $clienteMock, $pagamentoMock, $carteiraMock1);

        $this->assertInstanceOf(TransacaoDto::class, $response);
    }

    public static function invokeProvider(): array
    {
        $ordemMock1 = new OrdemDto('12345');

        $clienteMock1 = ClienteDto::fromArray([
            'nome' => 'John Doe',
            'status' => ClienteStatus::NOVO->value,
        ]);

        $pagamentoMock1 = PagamentoDto::fromArray([
            'tipo' => PagamentoTipo::CARTAO_DE_CREDITO->value,
            'valor' => 1000,
            'provedor' => ProvedorTipo::SIMULADO->value,
        ]);

        $carteiraMock1 = CarteiraDto::fromArray([
            'tipo' => CarteiraTipo::CLICK2PAY->value,
            'cavv' => '1234567890',
            'eci' => '05',
            'chave' => '1234567890abcdef',
        ]);

        return [
            [$ordemMock1, $clienteMock1, $pagamentoMock1, $carteiraMock1, 'success'],
        ];
    }
}
