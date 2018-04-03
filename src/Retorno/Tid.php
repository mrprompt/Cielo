<?php
namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;

class Tid
{
    /**
     * @Type("string")
     */
    protected $tid;

    /**
     * Get the value of tid
     * 
     * @return string
     */ 
    public function getTid(): string
    {
        return $this->tid;
    }
}