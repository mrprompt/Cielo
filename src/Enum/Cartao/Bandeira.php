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
        return match ($value) {
            'Visa' => self::VISA,
            'VISA' => self::VISA,
            'Master' => self::MASTERCARD,
            'MASTER' => self::MASTERCARD,
            'MASTERCARD' => self::MASTERCARD,
            'Elo' => self::ELO,
            'ELO' => self::ELO,
            'Amex' => self::AMEX,
            'AMEX' => self::AMEX,
            'Diners' => self::DINERS,
            'DINERS' => self::DINERS,
            'Discover' => self::DISCOVER,
            'DISCOVER' => self::DISCOVER,
            'JCB' => self::JCB,
            'Aura' => self::AURA,
            'AURA' => self::AURA,
            default => throw new ValidacaoErrors("Bandeira inválida: {$value}")
        };
    }

    public static function bandeiras(): array
    {
        return array_column(self::cases(), 'value');
    }
}
