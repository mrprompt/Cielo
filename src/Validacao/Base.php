<?php

namespace MrPrompt\Cielo\Validacao;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

abstract class Base
{
    protected static $erros = [];

    public static function validate(Dto $dto): mixed
    {
        static::$erros = [];
        
        $campos = $dto->toRequest();
        // print_r($campos); 
        // exit;

        array_walk(
            $campos,
            fn($value, $field) => forward_static_call_array(
                [
                    static::class, 
                    "{$field}Validate",
                ],
                [
                    $value
                ]
            ),
        );

        if (sizeof(static::$erros) === 0) {
            return true;
        } 
        
        $exception = new ValidacaoErrors("Erros encontrados.");
        $exception->setDetails(static::$erros);
        // print_r(static::$erros);

        throw $exception;
    }
}
