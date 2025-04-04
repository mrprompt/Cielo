<?php

namespace MrPrompt\Cielo\Tests\Recursos\Cartao;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as EnderecoTipo;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Pagamento\Moeda as MoedaTipo;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Enum\Pagamento\Parcelamento as ParcelamentoTipo;
use MrPrompt\Cielo\Enum\Cartao\Tipo as CartaoTipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as CartaoBandeira;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;
use MrPrompt\Cielo\Recursos\Cartao\Pagamento;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;


class PagamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('invokeProvider')]
    #[TestDox('Testing Pagamento __invoke method with ordem $ordemMock->identificador and cliente $clienteMock->nome')]
    public function testInvoke($ordemMock, $clienteMock, $pagamentoMock, $expectedStatus)
    {
        $jsonObject = '{"MerchantOrderId":"12345","Customer":{"Name":"John Doe","Identity":"12345678900","IdentityType":"CPF","Email":"john.doe@example.com","Birthdate":"1980-01-01","Address":{"Street":"123 Main St","Number":"","Complement":"","ZipCode":"12345","City":"Anytown","State":"SC","Country":"BRA","AddressType":0},"DeliveryAddress":{"Street":"456 Elm St","Number":"","Complement":"","ZipCode":"67890","City":"Othertown","State":"SC","Country":"BRA","AddressType":0},"Status":"NEW"},"Payment":{"ServiceTaxAmount":0,"Installments":1,"Interest":0,"Capture":true,"Authenticate":false,"Recurrent":false,"CreditCard":{"CardNumber":"123456******3456","Holder":"John Doe","ExpirationDate":"12/2025","SaveCard":false,"CardToken":"token123","CardType":"CreditCard","Brand":"Visa"},"Tid":"0327011932082","SoftDescriptor":"no nonono nonono","Provider":"Simulado","IsQrCode":false,"Amount":1000,"ReceivedDate":"2025-03-27 13:19:32","Status":0,"IsSplitted":false,"ReturnMessage":"Timeout","ReturnCode":"99","PaymentId":"8c90d52d-2eae-426e-9a98-03ff9e59274e","Type":"CreditCard","Currency":"BRL","Country":"BRA","Links":[{"Method":"GET","Rel":"self","Href":"https://apiquerysandbox.cieloecommerce.cielo.com.br/1/sales/8c90d52d-2eae-426e-9a98-03ff9e59274e"}]}}';
        $mockResponse = $this->getMockBuilder(Response::class)->getMock();
        $mockResponse->method('getBody')->willReturn(new Stream(fopen('data://application/json,' . $jsonObject,'r')));

        $httpDriverMock = $this->createMock(HttpDriver::class);
        $httpDriverMock->expects($this->once())
            ->method('post')
            ->with(
                '1/sales',
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
            'status' => Status::NOVO->value,
            'documento' => [
                'numero' => '12345678900',
                'tipo' => 'CPF'
            ],
            'email' => 'john.doe@example.com',
            'nascimento' => '1980-01-01',
            'endereco' => [
                'tipo' => EnderecoTipo::RESIDENCIAL->value,
                'endereco' => '123 Main St',
                'cidade' => 'Anytown',
                'estado' => Estado::SC->value,
                'cep' => '12345',
                'pais' => Pais::BRASIL->value
            ],
            'entrega' => [
                'tipo' => EnderecoTipo::ENTREGA->value,
                'endereco' => '456 Elm St',
                'cidade' => 'Othertown',
                'estado' => Estado::SC->value,
                'cep' => '67890',
                'pais' => Pais::BRASIL->value
            ],
            'cobranca' => [
                'tipo' => EnderecoTipo::COBRANCA->value,
                'endereco' => '789 Oak St',
                'cidade' => 'Sometown',
                'estado' => Estado::SC->value,
                'cep' => '11223',
                'pais' => Pais::BRASIL->value
            ],
        ]);
    
        $pagamentoMock1 = PagamentoDto::fromArray([
            'tipo' => PagamentoTipo::CARTAO_DE_CREDITO->value,
            'valor' => 1000,
            'moeda' => MoedaTipo::REAL->value,
            'provedor' => ProvedorTipo::CIELO->value,
            'taxas' => 10,
            'descricao' => 'no nonono nonono',
            'parcelas' => 1,
            'parcelas_tipo' => ParcelamentoTipo::CARTAO->value,
            'captura' => true,
            'autenticacao' => false,
            'recorrente' => false,
            'criptomoeda' => false,
            'cartao' => [
                'tipo' => CartaoTipo::CREDITO->value,
                'bandeira' => CartaoBandeira::VISA->value,
                'numero' => '1234567890123456',
                'validade' => '12/2025',
                'codigoSeguranca' => '123',
                'portador' => 'John Doe',
                'token' => 'token123'
            ],
        ]);
    
        return [
            [$ordemMock1, $clienteMock1, $pagamentoMock1, 'success'],
        ];
    }
    
}