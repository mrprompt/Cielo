<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\Validacao\Pagamento;

class PagamentoTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid number')]
    public function testValidatePassesForValidOrderNumber(): void
    {
        $bin = PagamentoDto::fromArray(['identificador' => '5502095822650000']);

        $this->assertTrue(Pagamento::validate($bin));
    }
}
