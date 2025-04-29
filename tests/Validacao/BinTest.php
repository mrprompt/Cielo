<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Bin as BinDto;
use MrPrompt\Cielo\Validacao\Bin;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

class BinTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid Bin number')]
    public function testValidatePassesForValidBinNumber(): void
    {
        $bin = BinDto::fromArray(['numero' => '5502095822650000']);

        $this->assertTrue(Bin::validate($bin));
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid Bin number')]
    public function testValidateThrowsExceptionForInvalidBinNumber(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Erros encontrados.');

        $bin = BinDto::fromArray(['numero' => 'invalid_number']);

        Bin::validate($bin);
    }
}
