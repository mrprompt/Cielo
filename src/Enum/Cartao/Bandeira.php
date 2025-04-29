<?php

namespace MrPrompt\Cielo\Enum\Cartao;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Bandeira: string 
{
    case VISA = 'Visa';
    case MASTERCARD = 'Master';
    case ELO = 'Elo';
    case AMEX = 'Amex';
    case DINERS = 'Diners';
    case DISCOVER = 'Discover';
    case JCB = 'JCB';
    case AURA = 'Aura';

    public static function match(string $value): self
    {
        foreach (self::cases() as $case) {
            if (strtolower($case->value) === (string) strtolower($value)) {
                return $case;
            }
        }

        throw new ValidacaoErrors("Bandeira inválida: {$value}");
    }

    public static function bandeiras(): array
    {
        return array_column(self::cases(), 'value');
    }
}
