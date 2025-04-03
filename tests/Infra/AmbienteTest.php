<?php

namespace MrPrompt\Cielo\Tests\Infra;

use MrPrompt\Cielo\Infra\Ambiente;
use MrPrompt\Cielo\Enum\Ambiente\Producao;
use MrPrompt\Cielo\Enum\Ambiente\Sandbox;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AmbienteTest extends TestCase
{
    #[Test]
    public function transacionalProducao()
    {
        $ambiente = new Ambiente(Ambiente::PRODUCAO);
        $result = $ambiente->transacional();

        $this->assertEquals(Producao::TRANSACIONAL->value, $result);
    }

    #[Test]
    public function transacionalSandbox()
    {
        $ambiente = new Ambiente(Ambiente::SANDBOX);
        $result = $ambiente->transacional();
        
        $this->assertEquals(Sandbox::TRANSACIONAL->value, $result);
    }

    #[Test]
    public function transacionalAmbienteInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ambiente inválido');

        $ambiente = new Ambiente('invalido');
        $ambiente->transacional();
    }

    #[Test]
    public function consultasProducao()
    {
        $ambiente = new Ambiente(Ambiente::PRODUCAO);
        $result = $ambiente->consultas();
        
        $this->assertEquals(Producao::CONSULTAS->value, $result);
    }

    #[Test]
    public function consultasSandbox()
    {
        $ambiente = new Ambiente(Ambiente::SANDBOX);
        $result = $ambiente->consultas();
        
        $this->assertEquals(Sandbox::CONSULTAS->value, $result);
    }

    #[Test]
    public function consultasAmbienteInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ambiente inválido');

        $ambiente = new Ambiente('invalido');
        $ambiente->consultas();
    }
}
