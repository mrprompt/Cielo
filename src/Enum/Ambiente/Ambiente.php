<?php

namespace MrPrompt\Cielo\Enum\Ambiente;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Contratos\Ambiente as AmbienteInterface;

enum Ambiente: string
{
    case PRODUCAO = 'producao';
    case SANDBOX = 'sandbox';
    
    public static function match (string $ambiente): AmbienteInterface
    {
        return match ($ambiente) {
            self::PRODUCAO->value => new class implements AmbienteInterface {
                public function transacional(): string 
                {
                    return 'https://api.cieloecommerce.cielo.com.br/';
                }

                public function consultas(): string 
                {
                    return 'https://apiquery.cieloecommerce.cielo.com.br/';
                }
            },
            self::SANDBOX->value => new class implements AmbienteInterface {
                public function transacional(): string 
                {
                    return 'https://apisandbox.cieloecommerce.cielo.com.br/';
                }

                public function consultas(): string 
                {
                    return 'https://apiquerysandbox.cieloecommerce.cielo.com.br/';
                }
            },
            default => throw new ValidacaoErrors("Ambiente inválido: {$ambiente}"),
        };
    }

    public static function ambientes(): array
    {
        return array_column(self::cases(), 'value');
    }
}
