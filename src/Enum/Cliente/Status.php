<?php

namespace MrPrompt\Cielo\Enum\Cliente;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Status: string
{
    case NOVO = 'NEW';
    case EXISTENTE = 'EXISTING';

    public static function match(string $status): self
    {
        return match ($status) {
            'NEW' => self::NOVO,
            'NOVO' => self::NOVO,
            'EXISTING' => self::EXISTENTE,
            'EXISTENTE' => self::EXISTENTE,
            default => throw new ValidacaoErrors("Status de usuário inválido: {$status}")
        };
    }

    public static function status(): array
    {
        return array_column(self::cases(), 'value');
    }
}
