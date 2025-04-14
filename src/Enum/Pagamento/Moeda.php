<?php

namespace MrPrompt\Cielo\Enum\Pagamento;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

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
        foreach (self::cases() as $case) {
            if ($case->value === (string) $moeda) {
                return $case;
            }
        }

        throw new ValidacaoErrors("Moeda inválida: {$moeda}");
    }

    public static function moedas(): array
    {
        return array_column(self::cases(), 'value');
    }
}
