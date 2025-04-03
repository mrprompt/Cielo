<?php

namespace MrPrompt\Cielo\Infra;

use MrPrompt\Cielo\Enum\Ambiente\Producao;
use MrPrompt\Cielo\Enum\Ambiente\Sandbox;

class Ambiente
{
    public const PRODUCAO = 'producao';
    public const SANDBOX = 'sandbox';

    public function __construct(private readonly string $ambiente = self::PRODUCAO) {}

    public function transacional(): string
    {
        return match ($this->ambiente) {
            self::PRODUCAO => Producao::TRANSACIONAL->value,
            self::SANDBOX => Sandbox::TRANSACIONAL->value,
            default => throw new \InvalidArgumentException('Ambiente inválido'),
        };
    }

    public function consultas(): string
    {
        return match ($this->ambiente) {
            self::PRODUCAO => Producao::CONSULTAS->value,
            self::SANDBOX => Sandbox::CONSULTAS->value,
            default => throw new \InvalidArgumentException('Ambiente inválido'),
        };
    }
}
