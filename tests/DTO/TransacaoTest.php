<?php

namespace MrPrompt\Cielo\Tests\DTO;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Pagamento;
use MrPrompt\Cielo\DTO\Transacao;
use MrPrompt\Cielo\Enum\Pagamento\Moeda;
use MrPrompt\Cielo\Enum\Pagamento\Parcelamento;
use MrPrompt\Cielo\Enum\Pagamento\Provedor;
use MrPrompt\Cielo\Enum\Pagamento\Tipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as TipoEndereco;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;
use MrPrompt\Cielo\Enum\Cliente\Status as ClienteStatus;
use MrPrompt\Cielo\Tests\TestCase;

class TransacaoTest extends TestCase
{
    #[Test]
    #[DataProvider('transacaoProvider')]
    #[TestDox('Testing Pagamento fromRequest with tipo $requestData[tipo] and valor $requestData[valor]')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = json_decode(json_encode($requestData));
        $transacao = Transacao::fromRequest($request);

        $this->assertEquals($expectedData['ordem']['identificador'], $transacao->ordem->identificador);
    }

    #[Test]
    #[DataProvider('transacaoProvider')]
    #[TestDox('Testing Pagamento fromArray with tipo $requestData[tipo] and valor $requestData[valor]')]
    public function testFromArray($requestData, $expectedData)
    {
        $modifiedData = $expectedData;
        $modifiedData['cliente']['status'] = $expectedData['cliente']['status']->value;
        $modifiedData['cliente']['nascimento'] = $expectedData['cliente']['nascimento']->format('Y-m-d');
        $modifiedData['cliente']['endereco']['tipo'] = $expectedData['cliente']['endereco']['tipo']->value;
        $modifiedData['cliente']['endereco']['estado'] = $expectedData['cliente']['endereco']['estado']->value;
        $modifiedData['cliente']['endereco']['pais'] = $expectedData['cliente']['endereco']['pais']->value;
        $modifiedData['cliente']['entrega']['tipo'] = $expectedData['cliente']['entrega']['tipo']->value;
        $modifiedData['cliente']['entrega']['estado'] = $expectedData['cliente']['entrega']['estado']->value;
        $modifiedData['cliente']['entrega']['pais'] = $expectedData['cliente']['entrega']['pais']->value;
        $modifiedData['cliente']['cobranca']['tipo'] = $expectedData['cliente']['cobranca']['tipo']->value;
        $modifiedData['cliente']['cobranca']['estado'] = $expectedData['cliente']['cobranca']['estado']->value;
        $modifiedData['cliente']['cobranca']['pais'] = $expectedData['cliente']['cobranca']['pais']->value;
        $modifiedData['pagamento']['tipo'] = $expectedData['pagamento']['tipo']->value;
        $modifiedData['pagamento']['moeda'] = $expectedData['pagamento']['moeda']->value;
        $modifiedData['pagamento']['provedor'] = $expectedData['pagamento']['provedor']->value;
        $modifiedData['pagamento']['parcelas_tipo'] = $expectedData['pagamento']['parcelas_tipo']->value;
        $modifiedData['pagamento']['cartao']['tipo'] = $expectedData['pagamento']['cartao']['tipo']->value;
        $modifiedData['pagamento']['cartao']['bandeira'] = $expectedData['pagamento']['cartao']['bandeira']->value;

        $transacao = Transacao::fromArray($modifiedData);

        $this->assertEquals($expectedData['pagamento']['cartao']['tipo'], $transacao->pagamento->cartao->tipo);
    }

    public static function transacaoProvider(): array
    {
        return [
            [
                'requestData' => [
                    'MerchantOrderId' => '123456',
                    'Customer' => [
                        'Name' => 'John Doe',
                        'Status' => 'NEW',
                        'Identity' => '12345678900',
                        'IdentityType' => 'CPF',
                        'Email' => 'john.doe@example.com',
                        'Birthdate' => '1980-01-01',
                        'Address' => [
                            'Street' => '123 Main St',
                            'City' => 'Anytown',
                            'State' => Estado::SC->value,
                            'ZipCode' => '12345',
                            'Country' => Pais::BRASIL->value,
                        ],
                        'DeliveryAddress' => [
                            'Street' => '456 Elm St',
                            'City' => 'Othertown',
                            'State' => Estado::SC->value,
                            'ZipCode' => '67890',
                            'Country' => Pais::BRASIL->value,
                        ],
                        'Billing' => [
                            'Street' => '789 Oak St',
                            'City' => 'Sometown',
                            'State' => Estado::SC->value,
                            'ZipCode' => '11223',
                            'Country' => Pais::BRASIL->value,
                        ]
                    ],
                    'Payment' => [
                        'Type' => Tipo::CARTAO_DE_CREDITO->value,
                        'Amount' => 1000,
                        'Currency' => Moeda::REAL->value,
                        'Provider' => Provedor::CIELO->value,
                        'ServiceTaxAmount' => 10,
                        'SoftDescriptor' => 'no nonono nonono',
                        'Installments' => 1,
                        'Interest' => Parcelamento::CARTAO->value,
                        'Capture' => true,
                        'Authenticate' => false,
                        'Recurrent' => false,
                        'IsCryptocurrencyNegociation' => false,
                        'CreditCard' => [
                            'CardType' => TipoCartao::CREDITO->value,
                            'Brand' => Bandeira::VISA->value,
                            'CardNumber' => '1234567890123456',
                            'ExpirationDate' => '12/2025',
                            'SecurityCode' => '123',
                            'Holder' => 'John Doe',
                            'CardToken' => 'token123'
                        ],
                    ],
                ],
                'expectedData' => [
                    'ordem' => [
                        'identificador' => '123456',
                    ],
                    'cliente' => [
                        'nome' => 'John Doe',
                        'status' => ClienteStatus::match('NEW'),
                        'documento' => [
                            'numero' => '12345678900',
                            'tipo' => 'CPF'
                        ],
                        'email' => 'john.doe@example.com',
                        'nascimento' => new \DateTime('1980-01-01'),
                        'endereco' => [
                            'tipo' => TipoEndereco::PRINCIPAL,
                            'endereco' => '123 Main St',
                            'numero' => '100',
                            'complemento' => 'Apt 1',
                            'cep' => '12345',
                            'cidade' => 'Anytown',
                            'estado' => Estado::SC,
                            'pais' => Pais::BRASIL
                        ],
                        'entrega' => [
                            'tipo' => TipoEndereco::ENTREGA,
                            'endereco' => '456 Elm St',
                            'numero' => '200',
                            'complemento' => null,
                            'cep' => '67890',
                            'cidade' => 'Othertown',
                            'estado' => Estado::SC,
                            'pais' => Pais::BRASIL
                        ],
                        'cobranca' => [
                            'tipo' => TipoEndereco::COBRANCA,
                            'endereco' => '456 Elm St',
                            'numero' => '200',
                            'complemento' => null,
                            'cep' => '67890',
                            'cidade' => 'Othertown',
                            'estado' => Estado::SC,
                            'pais' => Pais::BRASIL
                        ],
                    ],
                    'pagamento' => [
                        'tipo' => Tipo::CARTAO_DE_CREDITO,
                        'valor' => 1000,
                        'moeda' => Moeda::REAL,
                        'provedor' => Provedor::CIELO,
                        'taxas' => 10,
                        'descricao' => 'no nonono nonono',
                        'parcelas' => 1,
                        'parcelas_tipo' => Parcelamento::CARTAO,
                        'captura' => true,
                        'autenticacao' => false,
                        'recorrente' => false,
                        'criptomoeda' => false,
                        'cartao' => [
                            'tipo' => TipoCartao::CREDITO,
                            'bandeira' => Bandeira::VISA,
                            'numero' => '1234567890123456',
                            'validade' => '12/2025',
                            'codigoSeguranca' => '123',
                            'portador' => 'John Doe',
                            'token' => 'token123'
                        ],
                    ],
                ],
            ],
        ];
    }
}
