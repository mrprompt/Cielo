<?php

namespace MrPrompt\Cielo\Tests\Enum\Pagamento;

use MrPrompt\Cielo\Enum\Pagamento\Tipo;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class TipoTest extends TestCase
{
    #[DataProvider('validTypesProvider')]
    public function testMatchReturnsCorrectEnumForValidTypes(string $input, object $expected): void
    {
        $this->assertSame($expected, Tipo::match($input));
    }

    public static function validTypesProvider(): array
    {
        return [
            ['CreditCard', Tipo::CARTAO_DE_CREDITO],
            ['DebitCard', Tipo::CARTAO_DE_DEBITO],
            ['Boleto', Tipo::BOLETO],
            ['Pix', Tipo::PIX],
        ];
    }

    public function testMatchThrowsExceptionForInvalidType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de pagamento inválido: InvalidType');

        Tipo::match('InvalidType');
    }

    #[Test]
    #[TestDox('Verifica se o método pagamentos retorna um array com os pagamentos válidos')]
    public function testPagamentosReturnsArray()
    {
        $this->assertIsArray(Tipo::pagamentos());
    }
}
