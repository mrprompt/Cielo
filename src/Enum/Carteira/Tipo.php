<?php

namespace MrPrompt\Cielo\Enum\Carteira;

enum Tipo: string 
{
    case APPLE_PAY = 'ApplePay';
    case GOOGLE_PAY = 'GooglePay';
    case SAMSUNG_PAY = 'SamsungPay';

    public static function match(string $value): self
    {
        return match ($value) {
            'ApplePay' => self::APPLE_PAY,
            'GooglePay' => self::GOOGLE_PAY,
            'SamsungPay' => self::SAMSUNG_PAY,
            default => throw new \InvalidArgumentException("Tipo de carteira inválida: {$value}")
        };
    }

    public static function carteiras(): array
    {
        return array_column(self::cases(), 'value');
    }
}
