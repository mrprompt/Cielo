<?php

namespace MrPrompt\Cielo\Validacao;

use DateTime;
use Respect\Validation\Validator as v;
use MrPrompt\Cielo\Enum\Cartao\Bandeira;

final class Cartao extends Base
{
    public static function CardTypeValidate($tipo)
    {
         if (!v::alnum()->notEmpty()->validate($tipo)) {
            static::$erros[] = 'Tipo de cartão inválido';
         }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function BrandValidate($bandeira)
    {
        if (!v::in(Bandeira::bandeiras(), true)->validate($bandeira)) {
            static::$erros[] = 'Bandeira inválida';
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function ExpirationDateValidate($validade)
    {
        $referencia = new DateTime;
        $validadeObj = DateTime::createFromFormat('m/Y', $validade);

        if (!v::date('m/Y')->validate($validade) || $validadeObj === false) {
            static::$erros[] = 'Data de validade inválida.';

            return false;
        }

        if ($validadeObj->diff($referencia)->days <= 0) {
            static::$erros[] = 'Cartão com validade ultrapassada.';

            return false;
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CustomerNameValidate($nome)
    {
        if (!v::stringType()->notEmpty()->validate($nome)) {
            static::$erros[] = 'Nome inválido';
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CardNumberValidate($numero)
    {
        if (!v::digit()
            ->noWhitespace()
            ->creditCard()
            ->validate($numero)) {
            static::$erros[] = 'Número de cartão inválido';
        }
        
        return (bool) sizeof(static::$erros) === 0;
    }

    public static function SecurityCodeValidate($codigo)
    {
        if (!v::digit()
            ->notEmpty()
            ->noWhitespace()
            ->validate($codigo)) {
            static::$erros[] = 'Código de segurança inválido';
        }
        
        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CardTokenValidate($token)
    {
        if (!v::notEmpty()
            ->noWhitespace()
            ->validate($token)) {
            static::$erros[] = 'Token inválido';
        }
        
        return (bool) sizeof(static::$erros) === 0;
    }

    public static function IssuerValidate($nome)
    {
        return true;
    }

    public static function IssuerCodeValidate($codigo)
    {
        return true;
    }

    public static function PrepaidValidate($prepago)
    {
        return true;
    }

    public static function HolderValidate($nome)
    {
        if (!v::stringType()->notEmpty()->validate($nome)) {
            static::$erros[] = 'Nome inválido';
        }

        return (bool) sizeof(static::$erros) === 0;
    }
}
