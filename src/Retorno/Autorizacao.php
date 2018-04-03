<?php
namespace MrPrompt\Cielo\Retorno;

use JMS\Serializer\Annotation\Type;

class Autorizacao
{
    /**
     * @Type("string")
     */
    protected $codigo;

    /**
     * @Type("string")
     */
    protected $mensagem;
}