<?php

namespace MrPrompt\Cielo\Exceptions;

use ArrayObject;
use Throwable;

class ValidacaoErrors extends Exception
{
    public readonly ArrayObject $erros;

    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
        $this->erros = new ArrayObject();
    }

    public function setDetails(array $erros): ArrayObject
    {
        array_walk(
            $erros,
            fn($value, $field) => $this->erros->append((object) ['Code' => $field, 'Message' => $value]),
        );

        return $this->erros;
    }
}
