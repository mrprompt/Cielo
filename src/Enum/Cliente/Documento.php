<?php

namespace MrPrompt\Cielo\Enum\Cliente;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Documento: string
{
    case CPF = 'CPF';
    case CNPJ = 'CNPJ';

    public static function match(string $tipo): self
    {
        return match ($tipo) {
            'CPF' => self::CPF,
            'CNPJ' => self::CNPJ,
            default => throw new ValidacaoErrors("Tipo de documento inválido: {$tipo}")
        };
    }

    public static function documentos(): array
    {
        return array_column(self::cases(), 'value');
    }
}
