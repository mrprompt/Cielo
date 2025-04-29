<?php

namespace MrPrompt\Cielo\Validacao;

use Respect\Validation\Validator as v;

final class Transacao extends Base
{
    public static function MerchantOrderIdValidate($input)
    {
        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CustomerValidate($input)
    {
        return (bool) sizeof(static::$erros) === 0;
    }

    public static function PaymentValidate($input)
    {
        return (bool) sizeof(static::$erros) === 0;
    }
}
