<?php

namespace MrPrompt\Cielo\Enum\Cartao;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Tipo: string
{
    case CREDITO = 'CreditCard';
    case DEBITO = 'DebitCard';
    case BOTH = 'Multiple';

    public static function match(string $value): self
    {
        return match ($value) {
            'CreditCard', 'Crédito' => self::CREDITO,
            'DebitCard', 'Débito' => self::DEBITO,
            'Múltiplo' => self::BOTH,
            default => self::throwInvalidType($value),
        };
    }

    public static function tipos(): array
    {
        return array_column(self::cases(), 'value');
    }

    private static function throwInvalidType(string $value): never
    {
        throw new ValidacaoErrors("Tipo de cartão inválido: {$value}");
    }
}
