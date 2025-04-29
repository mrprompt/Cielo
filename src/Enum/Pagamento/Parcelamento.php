<?php

namespace MrPrompt\Cielo\Enum\Pagamento;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Parcelamento: string 
{
    case LOJA = 'ByMerchant';
    case CARTAO = 'ByIssuer';
    case A_VISTA = '0';
    case PARCELADO = '1';

    public static function match(string $parcelamento): self
    {
        return match ($parcelamento) {
            self::LOJA->value => self::LOJA,
            self::CARTAO->value => self::CARTAO,
            self::A_VISTA->value => self::A_VISTA,
            self::PARCELADO->value => self::PARCELADO,
            default => throw new ValidacaoErrors("Tipo de parcelamento inválido: {$parcelamento}")
        };
    }

    public static function parcelamentos(): array
    {
        return array_column(self::cases(), 'value');
    }
}
