<?php

namespace MrPrompt\Cielo\Tests\Enum\Pagamento;

use MrPrompt\Cielo\Enum\Pagamento\Parcelamento;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\DataProvider;

class ParcelamentoTest extends TestCase
{
    #[Test]
    #[TestDox('Deve retornar Loja para o valor ByMerchant')]
    public function testMatchReturnsLojaForByMerchant(): void
    {
        $result = Parcelamento::match('ByMerchant');
        $this->assertSame(Parcelamento::LOJA, $result);
    }

    #[Test]
    #[TestDox('Deve retornar Cartão para o valor ByIssuer')]
    public function testMatchReturnsCartaoForByIssuer(): void
    {
        $result = Parcelamento::match('ByIssuer');
        $this->assertSame(Parcelamento::CARTAO, $result);
    }

    #[Test]
    #[TestDox('Deve lançar uma exceção para um valor inválido')]
    public function testMatchThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de parcelamento inválido: InvalidValue');
        Parcelamento::match('InvalidValue');
    }

    #[Test]
    #[TestDox('Deve retornar o valor esperado para diferentes tipos de parcelamento')]
    #[DataProvider('parcelamentoProvider')]
    public function testMatchWithDataProvider(string $input, object $expected): void
    {
        $result = Parcelamento::match($input);
        $this->assertSame($expected, $result);
    }

    public static function parcelamentoProvider(): array
    {
        return [
            ['ByMerchant', Parcelamento::LOJA],
            ['ByIssuer', Parcelamento::CARTAO],
        ];
    }

    #[Test]
    #[TestDox('Verifica se o método parcelamentos retorna um array com os parcelamentos válidos')]
    public function testParcelamentosReturnsArray()
    {
        $this->assertIsArray(Parcelamento::parcelamentos());
    }
}