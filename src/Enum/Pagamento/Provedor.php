<?php

namespace MrPrompt\Cielo\Enum\Pagamento;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Provedor: string 
{
    case CIELO = 'Cielo';
    case SIMULADO = 'Simulado';
    case BRADESCO = 'Bradesco2';
    case BANCO_DO_BRASIL = 'BancoDoBrasil2';

    public static function match(string $provedor): self
    {
        return match ($provedor) {
            self::CIELO->value => self::CIELO,
            self::SIMULADO->value => self::SIMULADO,
            self::BANCO_DO_BRASIL->value => self::BANCO_DO_BRASIL,
            self::BRADESCO->value => self::BRADESCO,
            default => throw new ValidacaoErrors("Provedor inválido: {$provedor}")
        };
    }

    public static function provedores(): array
    {
        return array_column(self::cases(), 'value');
    }
}
