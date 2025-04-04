<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\Validacao\Cartao;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

class CartaoTest extends TestCase
{
    public static function validCardData(): array
    {
        return [
            'valid visa card number' => [
                [
                    'numero' => '4235647728025682',
                    'tipo' => 'CreditCard',
                    'bandeira' => 'VISA',
                    'validade' => '11/2030',
                    'codigoSeguranca' => '123',
                    'nome' => 'John Doe',
                ],
            ],
            'valid master card number' => [
                [
                    'numero' => '5031433215406351',
                    'tipo' => 'CreditCard',
                    'bandeira' => 'MASTERCARD',
                    'validade' => '11/2030',
                    'codigoSeguranca' => '123',
                    'nome' => 'John Doe',
                ],
            ],
        ];
    }

    #[Test]
    #[TestDox('Ensure validate method passes for valid card')]
    #[DataProvider('validCardData')]
    public function testValidatePassesForValidCard($card): void
    {
        $cartao = CartaoDto::fromArray($card);

        $this->assertTrue(Cartao::validate($cartao));
    }

    public static function invalidCardData(): array
    {
        return [
            'invalid card number' => [
                [
                    'numero' => 'invalid_number',
                ],
            ],
            'invalid expiration date' => [
                [
                    'validade' => 'invalid_date',
                ],
            ],
            'negative value' => [
                [
                    'validade' => '-1000',
                ],
            ],
            'invalid card type' => [
                [
                    'tipo' => 'INVALID_CARD_TYPE',
                ],
            ],
            'invalid card brand' => [
                [
                    'bandeira' => 'INVALID_BRAND',
                ],
            ],
        ];
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid card')]
    #[DataProvider('invalidCardData')]
    public function testValidateThrowsExceptionForInvalidCard($card): void
    {
        $this->expectException(ValidacaoErrors::class);

        $cartao = CartaoDto::fromArray($card);

        Cartao::validate($cartao);
    }
}
