<?php

namespace MrPrompt\Cielo\Enum\Cliente;

enum Endereco: string
{
    case RESIDENCIAL = 'Address';
    case ENTREGA = 'DeliveryAddress';
    case COBRANCA = 'Billing';

    public static function match(string $tipo): self
    {
        return match ($tipo) {
            'Address' => self::RESIDENCIAL,
            'DeliveryAddress' => self::ENTREGA,
            'Billing' => self::COBRANCA,
            default => throw new \InvalidArgumentException("Tipo de endereço inválido: {$tipo}")
        };
    }

    public static function enderecos(): array
    {
        return [
            self::RESIDENCIAL,
            self::ENTREGA,
            self::COBRANCA,
        ];
    }
}
