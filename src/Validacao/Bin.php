<?php

namespace MrPrompt\Cielo\Validacao;

use Respect\Validation\Validator as v;

final class Bin extends Base
{
    public static function CardNumberValidate(?string $numero)
    {
        if (!v::notEmpty()
                ->noWhitespace()
                ->creditCard()
                ->validate($numero)) 
        {
            static::$erros[] = "Cartão inválido: {$numero}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }
}
