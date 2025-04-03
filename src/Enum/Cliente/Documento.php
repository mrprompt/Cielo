<?php

namespace MrPrompt\Cielo\Enum\Cliente;

enum Documento: string
{
    case CPF = 'CPF';
    case CNPJ = 'CNPJ';

    public static function match(string $tipo): self
    {
        return match ($tipo) {
            'CPF' => self::CPF,
            'CNPJ' => self::CNPJ,
            default => throw new \InvalidArgumentException("Tipo de documento inválido: {$tipo}")
        };
    }

    public static function documentos(): array
    {
        return array_column(self::cases(), 'value');
    }
}
