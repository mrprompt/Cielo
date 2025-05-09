<?php

namespace MrPrompt\Cielo\Enum\Carteira;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Tipo: string 
{
    case APPLE_PAY = 'ApplePay';
    case GOOGLE_PAY = 'GooglePay';
    case SAMSUNG_PAY = 'SamsungPay';
    case CLICK2PAY = 'Click2Pay';

    public static function match(string $value): self
    {
        return match ($value) {
            'ApplePay' => self::APPLE_PAY,
            'GooglePay' => self::GOOGLE_PAY,
            'SamsungPay' => self::SAMSUNG_PAY,
            'Click2Pay' => self::CLICK2PAY,
            default => throw new ValidacaoErrors("Tipo de carteira inválida: {$value}")
        };
    }

    public static function carteiras(): array
    {
        return array_column(self::cases(), 'value');
    }
}
