<?php

namespace MrPrompt\Cielo\Enum\Localizacao;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Endereco: string
{
    case PRINCIPAL = 'Address';
    case ENTREGA = 'DeliveryAddress';
    case COBRANCA = 'Billing';

    public static function match(string $tipo): self
    {
        return match ($tipo) {
            'Address' => self::PRINCIPAL,
            'principal' => self::PRINCIPAL,
            'DeliveryAddress' => self::ENTREGA,
            'entrega' => self::ENTREGA,
            'Billing' => self::COBRANCA,
            'cobranca' => self::COBRANCA,
            default => throw new ValidacaoErrors("Tipo de endereço inválido: {$tipo}")
        };
    }

    public static function enderecos(): array
    {
        return [
            self::PRINCIPAL->tipo(),
            self::ENTREGA->tipo(),
            self::COBRANCA->tipo(),
        ];
    }

    public function tipo(): string
    {
        return match ($this) {
            self::PRINCIPAL => 'principal',
            self::ENTREGA => 'entrega',
            self::COBRANCA => 'cobranca',
        };
    }
}
