<?php

namespace MrPrompt\Cielo\Enum\Ambiente;

use MrPrompt\Cielo\Contratos\Ambiente as AmbienteInterface;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Sandbox: string implements AmbienteInterface
{
    case TRANSACIONAL = 'https://apisandbox.cieloecommerce.cielo.com.br/';
    case CONSULTAS = 'https://apiquerysandbox.cieloecommerce.cielo.com.br/';

    public function transacional(): string
    {
        return match ($this) {
            self::TRANSACIONAL => self::TRANSACIONAL->value,
            default => throw new ValidacaoErrors('Ambiente inválido'),
        };
    }

    public function consultas(): string
    {
        return match ($this) {
            self::CONSULTAS => self::CONSULTAS->value,
            default => throw new ValidacaoErrors('Ambiente inválido'),
        };
    }
}
