<?php

namespace MrPrompt\Cielo\Validacao;

use Respect\Validation\Validator as v;

final class Ordem extends Base
{
    public static function MerchantOrderIdValidate(?string $numero)
    {
        if (!v::notEmpty()->noWhitespace()->validate($numero)) {
            static::$erros[] = "Ordem inválida: {$numero}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }
}
