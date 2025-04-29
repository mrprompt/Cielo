<?php

namespace MrPrompt\Cielo\Validacao;

use MrPrompt\Cielo\Enum\Carteira\Tipo;
use Respect\Validation\Validator as v;

final class Carteira extends Base
{
    public static function TypeValidate($tipo)
    {
         if (!v::alnum()->notEmpty()->in(Tipo::carteiras())->validate($tipo)) {
            static::$erros[] = "Tipo de carteira inválida: {$tipo}";
         }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CavvValidate($cavv)
    {
         if (!v::alnum()->notEmpty()->validate($cavv)) {
            static::$erros[] = "Cavv inválido: {$cavv}";
         }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function EciValidate($eci)
    {
         if (!v::alnum()->notEmpty()->validate($eci)) {
            static::$erros[] = "Eci inválido: {$eci}";
         }

        return (bool) sizeof(static::$erros) === 0;
    }
}
