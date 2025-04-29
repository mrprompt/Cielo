<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\Validacao\Ordem;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

class OrdemTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid number')]
    public function testValidatePassesForValidOrderNumber(): void
    {
        $bin = OrdemDto::fromArray(['identificador' => '5502095822650000']);

        $this->assertTrue(Ordem::validate($bin));
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid number')]
    public function testValidateThrowsExceptionForInvalidOrderNumber(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Erros encontrados.');

        $bin = OrdemDto::fromArray(['identificador' => '']);

        Ordem::validate($bin);
    }
}
