<?php

namespace MrPrompt\Cielo\Enum\Ambiente;

use MrPrompt\Cielo\Contratos\Ambiente as AmbienteInterface;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Producao: string implements AmbienteInterface
{
    case TRANSACIONAL = 'https://api.cieloecommerce.cielo.com.br/';
    case CONSULTAS = 'https://apiquery.cieloecommerce.cielo.com.br/';

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
