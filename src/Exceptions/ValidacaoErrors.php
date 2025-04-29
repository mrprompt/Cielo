<?php

namespace MrPrompt\Cielo\Exceptions;

use ArrayObject;
use Exception;

class ValidacaoErrors extends Exception
{
    public ArrayObject $erros;

    public function __construct($exception = "", $code = 0, $prev = null)
    {
        parent::__construct($exception, $code, $prev);

        $this->erros = new ArrayObject();
    }

    public function setDetails(array $erros)
    {
        array_walk(
            $erros,
            fn($value, $field) => $this->erros->append((object) ['Code' => $field, 'Message' => $value]),
        );

        return $this->erros;
    }
}
