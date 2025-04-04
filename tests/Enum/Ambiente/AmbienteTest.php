<?php

namespace MrPrompt\Cielo\Tests\Enum\Ambiente;

use MrPrompt\Cielo\Enum\Ambiente\Ambiente;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Contratos\Ambiente as AmbienteInterface;
use MrPrompt\Cielo\Tests\TestCase;

class AmbienteTest extends TestCase
{
    public function testMatchReturnsCorrectInstanceForProducao(): void
    {
        $ambiente = Ambiente::match('producao');

        $this->assertInstanceOf(AmbienteInterface::class, $ambiente);
        $this->assertSame('https://api.cieloecommerce.cielo.com.br/', $ambiente->transacional());
        $this->assertSame('https://apiquery.cieloecommerce.cielo.com.br/', $ambiente->consultas());
    }

    public function testMatchReturnsCorrectInstanceForSandbox(): void
    {
        $ambiente = Ambiente::match('sandbox');

        $this->assertInstanceOf(AmbienteInterface::class, $ambiente);
        $this->assertSame('https://apisandbox.cieloecommerce.cielo.com.br/', $ambiente->transacional());
        $this->assertSame('https://apiquerysandbox.cieloecommerce.cielo.com.br/', $ambiente->consultas());
    }

    public function testMatchThrowsExceptionForInvalidAmbiente(): void
    {
        $this->expectException(ValidacaoErrors::class);
        $this->expectExceptionMessage('Ambiente inválido: invalid');

        Ambiente::match('invalid');
    }

    public function testAmbientesReturnsAllCases(): void
    {
        $expected = ['producao', 'sandbox'];

        $this->assertSame($expected, Ambiente::ambientes());
    }
}