<?php

namespace MrPrompt\Cielo\Enum\Pagamento;

enum Moeda: string 
{
    case REAL = 'BRL';
    case DOLAR = 'USD';
    case EURO = 'EUR';
    case LIBRA = 'GBP';
    case PESO_ARGENTINO = 'ARS';
    case PESO_CHILENO = 'CLP';
    case PESO_URUGUAIO = 'UYU';
    case PESO_MEXICANO = 'MXN';
    case FRANCO_SUICO = 'CHF';
    case IENE = 'JPY';
    case YUAN = 'CNY';
    case COROA_SUECA = 'SEK';

    public static function match(string $moeda): self
    {
        return match ($moeda) {
            'BRL' => self::REAL,
            'USD' => self::DOLAR,
            'EUR' => self::EURO,
            'GBP' => self::LIBRA,
            'ARS' => self::PESO_ARGENTINO,
            'CLP' => self::PESO_CHILENO,
            'UYU' => self::PESO_URUGUAIO,
            'MXN' => self::PESO_MEXICANO,
            'CHF' => self::FRANCO_SUICO,
            'JPY' => self::IENE,
            'CNY' => self::YUAN,
            'SEK' => self::COROA_SUECA,
            default => throw new \InvalidArgumentException("Moeda inválida: {$moeda}")
        };
    }

    public static function moedas(): array
    {
        return array_column(self::cases(), 'value');
    }
}
