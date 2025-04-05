<?php

namespace MrPrompt\Cielo\Tests\Recursos\Boleto;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Cliente\Status as ClienteStatus;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as EnderecoTipo;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Recursos\Boleto\Pagamento;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

class PagamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('invokeProvider')]
    #[TestDox('Testing Boleto payment method')]
    public function testInvoke($ordemMock, $clienteMock, $pagamentoMock, $expectedStatus)
    {
        $jsonObject = '{"MerchantOrderId":"67ef7f65805e6","Customer":{"Name":"John Doe","Identity":"12345678900","IdentityType":"CPF","Address":{"Street":"Main St","Number":"123","ZipCode":"12345","City":"Anytown","State":"SC","Country":"BRA","District":"Centro","AddressType":0},"Status":"NEW"},"Payment":{"ExpirationDate":"2025-04-07","Url":"https://transactionsandbox.pagador.com.br/post/pagador/reenvia.asp/8d60a4ad-2dfe-4264-8143-238d22e0d45b","BoletoNumber":"2-3","BarCodeNumber":"00091104400000010009999250000000000299999990","DigitableLine":"00099.99921 50000.000005 02999.999903 1 10440000001000","Address":"N/A, 1","Bank":0,"Amount":1000,"ReceivedDate":"2025-04-04 03:42:45","Provider":"Simulado","Status":1,"IsSplitted":false,"PaymentId":"8d60a4ad-2dfe-4264-8143-238d22e0d45b","Type":"Boleto","Currency":"BRL","Country":"BRA","Links":[{"Method":"GET","Rel":"self","Href":"https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/8d60a4ad-2dfe-4264-8143-238d22e0d45b"}]}}';
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
            'documento' => [
                'numero' => '12345678900',
                'tipo' => 'CPF'
            ],
            'enderecos' => [
                'principal' => [
                    'tipo' => EnderecoTipo::PRINCIPAL->value,
                    'numero' => '123',
                    'endereco' => 'Main St',
                    'bairro' => 'Centro',
                    'cidade' => 'Anytown',
                    'estado' => Estado::SC->value,
                    'cep' => '12345',
                    'pais' => Pais::BRASIL->value,
                ],
                'cobranca' => [
                    'tipo' => EnderecoTipo::COBRANCA->value,
                    'numero' => '456',
                    'endereco' => 'Oak St',
                    'cidade' => 'Sometown',
                    'bairro' => 'Centro',
                    'estado' => Estado::SC->value,
                    'cep' => '11223',
                    'pais' => Pais::BRASIL->value
                ],
            ],
        ]);

        $pagamentoMock1 = PagamentoDto::fromArray([
            'tipo' => PagamentoTipo::BOLETO->value,
            'valor' => 1000,
            'provedor' => ProvedorTipo::BANCO_DO_BRASIL->value,
        ]);

        return [
            [$ordemMock1, $clienteMock1, $pagamentoMock1, 'success'],
        ];
    }
}
