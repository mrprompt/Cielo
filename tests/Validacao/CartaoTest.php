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
    #[Test]
    #[TestDox('Ensure validate method passes for valid card')]
    public function testValidatePassesForValidCard(): void
    {
        $cartao = CartaoDto::fromArray(['numero' => '5502095822650000']);

        $this->assertTrue(Cartao::validate($cartao));
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid card')]
    public function testValidateThrowsExceptionForInvalidCard(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Erros encontrados.');

        $cartao = CartaoDto::fromArray(['numero' => 'invalid_number']);

        Cartao::validate($cartao);
    }
}
