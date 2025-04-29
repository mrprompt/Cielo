<?php

namespace MrPrompt\Cielo\Tests\Recursos\Carteira;

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
use MrPrompt\Cielo\Recursos\Carteira\Pagamento;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

class PagamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('invokeProvider')]
    #[TestDox('Testing Carteira payment method')]
    public function testInvoke($ordemMock, $clienteMock, $pagamentoMock, $expectedStatus)
    {
        $jsonObject = <<<EOF
{
    "MerchantOrderId": "67fd95fb29f6b",
    "Customer": {
        "Name": "John Doe",
        "Identity": "12345678900",
        "IdentityType": "CPF",
        "Address": {
        "Street": "Main St",
        "Number": "123",
        "ZipCode": "12345",
        "City": "Anytown",
        "State": "SC",
        "Country": "BRA",
        "District": "Centro",
        "AddressType": 0
        },
        "Status": "NEW"
    },
    "Payment": {
        "ExpirationDate": "2025-04-17",
        "Url": "https://transactionsandbox.pagador.com.br/post/pagador/reenvia.asp/02dcf3b5-ed0e-4a09-849b-1dee90885afb",
        "BoletoNumber": "131-3",
        "BarCodeNumber": "00095105400000010009999250000000013199999990",
        "DigitableLine": "00099.99921 50000.000013 31999.999902 5 10540000001000",
        "Address": "N/A, 1",
        "Bank": 0,
        "Amount": 1000,
        "ReceivedDate": "2025-04-14 20:10:51",
        "Provider": "Simulado",
        "Status": 1,
        "IsSplitted": false,
        "PaymentId": "02dcf3b5-ed0e-4a09-849b-1dee90885afb",
        "Type": "Boleto",
        "Currency": "BRL",
        "Country": "BRA",
        "Links": [
        {
            "Method": "GET",
            "Rel": "self",
            "Href": "https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/02dcf3b5-ed0e-4a09-849b-1dee90885afb"
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
        $ordemMock1 = new OrdemDto('12345');

        $clienteMock1 = ClienteDto::fromArray([
            'nome' => 'John Doe',
            'status' => ClienteStatus::NOVO->value,
        ]);

        $pagamentoMock1 = PagamentoDto::fromArray([
            'tipo' => PagamentoTipo::CARTAO_DE_CREDITO->value,
            'valor' => 1000,
            'provedor' => ProvedorTipo::SIMULADO->value,
            'carteira' => CarteiraDto::fromArray([
                'tipo' => CarteiraTipo::APPLE_PAY->value,
                'chave' => '9zcCAciwoTS+qBx8jWb++64eHT2QZTWBs6qMVJ0GO+AqpcDVkxGPNpOR/D1bv5AZ62+5lKvucati0+eu7hdilwUYT3n5swkHuIzX2KO80Apx/
SkhoVM5dqgyKrak5VD2/drcGh9xqEanWkyd7wl200sYj4QUMbeLhyaY7bCdnnpKDJgpOY6J883fX3TiHoZorb/QlEEOpvYcbcFYs3ELZ7QVtjxyr
O2LmPsIkz2BgNm5f+JaJUSAOectahgLZnZR+easdhghrsa/E9A6DwjMd0fDYnxjj0bQDfaZpBPeGGPFLu5YYn1IDc',
            ]),
        ]);

        return [
            [$ordemMock1, $clienteMock1, $pagamentoMock1, 'success'],
        ];
    }
}
