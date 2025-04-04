<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Validacao\Pagamento;

class PagamentoTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid values')]
    public function testValidatePassesForValidPaymentData(): void
    {
        $bin = PagamentoDto::fromArray([
            'identificador' => '5502095822650000',
            'tipo' => 'CreditCard',
            'valor' => 1000,
            'moeda' => 'BRL',
            'bandeira' => 'Visa',
            'descricao' => 'Teste de pagamento',
            'parcelas' => 1,
            'taxaServico' => 0,
            'descricao' => 'Teste',
            'provedor' => 'Cielo',
            'captura' => true,
        ]);

        $this->assertTrue(Pagamento::validate($bin));
    }


    public static function invalidPaymentDataProvider(): array
    {
        return [
            'missing required fields' => [
                [
                    'identificador' => '',
                    'tipo' => '',
                ],
            ],
            'invalid card type' => [
                [
                    'identificador' => '5502095822650000',
                    'tipo' => 'InvalidCardType',
                ],
            ],
            'negative value' => [
                [
                    'identificador' => '5502095822650000',
                    'tipo' => 'CreditCard',
                    'valor' => -1000,
                ],
            ],
            'invalid currency' => [
                [
                    'moeda' => 'boo',
                ],
            ],
            'invalid provider' => [
                [
                    'provedor' => 'InvalidProvider',
                ],
            ],
            'invalid tax' => [
                [
                    'taxas' => -1,
                ],
            ],
            'invalid installments' => [
                [
                    'parcelas' => -1,
                ],
            ],
        ];
    }

    #[Test]
    #[TestDox('Ensure validate method handles invalid payment data')]
    #[DataProvider('invalidPaymentDataProvider')]
    public function testValidatePassesForInValidPaymentData($pagamento): void
    {
        $this->expectException(ValidacaoErrors::class);

        $bin = PagamentoDto::fromArray($pagamento);

        Pagamento::validate($bin);
    }
}
