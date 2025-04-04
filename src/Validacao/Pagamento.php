<?php

namespace MrPrompt\Cielo\Validacao;

use MrPrompt\Cielo\Enum\Pagamento\Moeda;
use MrPrompt\Cielo\Enum\Pagamento\Parcelamento;
use MrPrompt\Cielo\Enum\Pagamento\Provedor;
use MrPrompt\Cielo\Enum\Pagamento\Tipo;
use Respect\Validation\Validator as v;

final class Pagamento extends Base
{
    public static function PaymentIdValidate($input): bool
    {
        if (!v::alnum()->notEmpty()->validate($input)) {
            static::$erros[] = "Id de pagamento inválido: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function TypeValidate($input): bool
    {
        if (!v::in(Tipo::pagamentos(), true)->validate($input)) {
            static::$erros[] = 'Tipo de pagamento inválido';
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function AmountValidate($input): bool
    {
        if (!v::digit()->validate($input)) {
            static::$erros[] = "Valor inválido: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CurrencyValidate($input): bool
    {
        if (!v::in(Moeda::moedas(), true)->validate($input)) {
            static::$erros[] = 'Moeda inválida';
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function ProviderValidate($input): bool
    {
        if (!v::in(Provedor::provedores(), true)->validate($input)) {
            static::$erros[] = 'Provedor inválido';
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function ServiceTaxAmountValidate($input): bool
    {
        if (!v::notEmpty()->greaterThan(0)->validate($input)) {
            static::$erros[] = "Taxa inválida: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function SoftDescriptorValidate($input): bool
    {
        if (!v::stringType()->notBlank()->validate($input)) {
            static::$erros[] = "Descrição inválida: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function InstallmentsValidate($input): bool
    {
        if (!v::notEmpty()->greaterThan(0)->validate($input)) {
            static::$erros[] = "Número de parcelas inválida: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function InterestValidate($input): bool
    {
        if (!v::in(Parcelamento::parcelamentos(), true)->validate($input)) {
            static::$erros[] = 'Tipo de parcelamento inválido';
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function CaptureValidate($input): bool
    {
        if (!v::boolVal()->isValid($input)) {
            static::$erros[] = "Captura inválida: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function AuthenticateValidate($input): bool
    {
        if (!v::boolVal()->isValid($input)) {
            static::$erros[] = "Autenticação inválida: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function RecurrentValidate($input): bool
    {
        if (!v::boolVal()->isValid($input)) {
            static::$erros[] = "Recorrência inválida: {$input}";
        }

        return (bool) sizeof(static::$erros) === 0;
    }

    public static function IsCryptocurrencyNegociationValidate($input): bool
    {
        return true;
    }

    public static function CreditCardValidate($input): bool
    {
        return true;
    }

    public static function DebitCardValidate($input): bool
    {
        return true;
    }

    public static function TidValidate($input): bool
    {
        return true;
    }

    public static function IsQrCodeValidate($input): bool
    {
        return true;
    }

    public static function ReceivedDateValidate($input): bool
    {
        return true;
    }

    public static function StatusValidate($input): bool
    {
        return true;
    }

    public static function IsSplittedValidate($input): bool
    {
        return true;
    }

    public static function CountryValidate($input): bool
    {
        return true;
    }

    public static function ReturnMessageValidate($input): bool
    {
        return true;
    }

    public static function ReturnCodeValidate($input): bool
    {
        return true;
    }
}
