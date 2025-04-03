<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use InvalidArgumentException;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Carteira as CarteiraDto;
use MrPrompt\Cielo\Enum\Carteira\Tipo;
use MrPrompt\Cielo\Validacao\Carteira;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

class CarteiraTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid wallet')]
    public function testValidatePassesForValidWallet(): void
    {
        $carteira = CarteiraDto::fromArray([
            'tipo' => Tipo::GOOGLE_PAY->value, 
            'cavv' => '123', 
            'eci' => '12',
        ]);

        $this->assertTrue(Carteira::validate($carteira));
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid wallet')]
    public function testValidateThrowsExceptionForInvalidWallet(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de carteira inválida: invalid_type');

        $carteira = CarteiraDto::fromArray(['tipo' => 'invalid_type', 'cavv' => '123', 'eci' => '123']);
        Carteira::validate($carteira);
    }
}
