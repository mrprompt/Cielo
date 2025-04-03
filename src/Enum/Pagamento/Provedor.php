<?php

namespace MrPrompt\Cielo\Enum\Pagamento;

enum Provedor: string 
{
    case CIELO = 'Cielo';
    case SIMULADO = 'Simulado';

    public static function match(string $provedor): self
    {
        return match ($provedor) {
            self::CIELO->value => self::CIELO,
            self::SIMULADO->value => self::SIMULADO,
            default => throw new \InvalidArgumentException("Provedor inválido: {$provedor}")
        };
    }

    public static function provedores(): array
    {
        return array_column(self::cases(), 'value');
    }
}
