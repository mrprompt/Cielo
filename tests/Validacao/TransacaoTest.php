<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Validacao\Transacao;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

class TransacaoTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid number')]
    public function testValidatePassesForValidOrderNumber(): void
    {
        $transacao = TransacaoDto::fromArray([
            'ordem' => [
                'identificador' => '5502095822650000'
            ],
            'cliente' => [
                'nome' => 'John Doe',
                'status' => 'NEW',
                'documento' => [
                    'numero' => '12345678900',
                    'tipo' => 'CPF'
                ],
                'email' => 'john.doe@example.com',
                'nascimento' => '1980-01-01',
                'endereco' => [
                    'endereco' => '123 Main St',
                    'cidade' => 'Anytown',
                    'estado' => 'SC',
                    'cep' => '12345',
                    'pais' => 'BRA',
                ],
                'entrega' => [
                    'endereco' => '456 Elm St',
                    'cidade' => 'Othertown',
                    'estado' => 'SC',
                    'cep' => '67890',
                    'pais' => 'BRA',
                ],
                'cobranca' => [
                    'endereco' => '789 Oak St',
                    'cidade' => 'Sometown',
                    'estado' => 'SC',
                    'cep' => '11223',
                    'pais' => 'BRA',
                ],
            ],
            'pagamento' => [
                'tipo' => 'CreditCard',
                'valor' => 1000,
                'moeda' => 'BRL',
                'provedor' => 'Cielo',
                'taxas' => 10,
                'descricao' => 'no nonono nonono',
                'parcelas' => 1,
                'captura' => true,
                'autenticacao' => false,
                'recorrente' => false,
                'criptomoeda' => false,
                'cartao' => [
                    'tipo' => 'CreditCard',
                    'bandeira' => 'Visa',
                    'numero' => '1234567890123456',
                    'validade' => '12/2025',
                    'codigoSeguranca' => '123',
                    'portador' => 'John Doe',
                    'token' => 'token123'
                ],
            ]
        ]);

        $this->assertTrue(Transacao::validate($transacao));
    }

    // #[Test]
    // #[TestDox('Ensure validate method throws exception for invalid number')]
    // public function testValidateThrowsExceptionForInvalidOrderNumber(): void
    // {
    //     $this->expectException(ValidacaoErrors::class);
    //     $this->expectExceptionMessage('Erros encontrados.');

    //     $transacao = TransacaoDto::fromArray(['identificador' => '']);

    //     Transacao::validate($transacao);
    // }
}
