<?php

namespace MrPrompt\Cielo\Exceptions;

use ArrayObject;
use Exception;

class CieloApiErrors extends Exception
{
    public ArrayObject $erros;

    public function setDetails(Exception $exception)
    {
        /**
         * @disregard 1013 Undefined method 'getResponse'
         */
        $erros = json_decode(strval($exception->getResponse()->getBody())) 
                ?? [(object)['Code' => $exception->getCode(), 'Message' => $exception->getMessage()]];
    
        $this->erros = new ArrayObject($erros);
    }
}
