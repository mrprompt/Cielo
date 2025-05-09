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
            'CreditCard' => self::CREDITO,
            'Crédito' => self::CREDITO,
            'DebitCard' => self::DEBITO,
            'Débito' => self::DEBITO,
            'Múltiplo' => self::BOTH,
            default => throw new ValidacaoErrors("Tipo de cartão inválido: {$value}")
        };
    }

    public static function tipos(): array
    {
        return array_column(self::cases(), 'value');
    }
}
