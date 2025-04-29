<?php

namespace MrPrompt\Cielo\Tests\DTO;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Pagamento;
use MrPrompt\Cielo\Enum\Pagamento\Moeda;
use MrPrompt\Cielo\Enum\Pagamento\Parcelamento;
use MrPrompt\Cielo\Enum\Pagamento\Provedor;
use MrPrompt\Cielo\Enum\Pagamento\Tipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Tests\TestCase;

class PagamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('pagamentoProvider')]
    #[TestDox('Testing Pagamento fromRequest with tipo $requestData[tipo] and valor $requestData[valor]')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = json_decode(json_encode($requestData));
        $pagamento = Pagamento::fromRequest($request);

        $this->assertEquals($expectedData['tipo'], $pagamento->tipo);
        $this->assertEquals($expectedData['valor'], $pagamento->valor);
        $this->assertEquals($expectedData['moeda'], $pagamento->moeda);
    }

    #[Test]
    #[DataProvider('pagamentoProvider')]
    #[TestDox('Testing Pagamento fromArray with tipo $requestData[tipo] and valor $requestData[valor]')]
    public function testFromArray($requestData, $expectedData)
    {
        $modifiedData = $expectedData;
        $modifiedData['tipo'] = $expectedData['tipo']->value;
        $modifiedData['moeda'] = $expectedData['moeda']->value;
        $modifiedData['provedor'] = $expectedData['provedor']->value;
        $modifiedData['parcelas_tipo'] = $expectedData['parcelas_tipo']->value;
        $modifiedData['cartao']['tipo'] = $expectedData['cartao']['tipo']->value;
        $modifiedData['cartao']['bandeira'] = $expectedData['cartao']['bandeira']->value;

        $pagamento = Pagamento::fromArray($modifiedData);

        $this->assertEquals($expectedData['tipo'], $pagamento->tipo);
        $this->assertEquals($expectedData['valor'], $pagamento->valor);
        $this->assertEquals($expectedData['moeda'], $pagamento->moeda);
    }

    public static function pagamentoProvider(): array
    {
        return [
            [
                'requestData' => [
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
                'expectedData' => [
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
                ]
            ],
        ];
    }
}
