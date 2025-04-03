<?php

namespace MrPrompt\Cielo\Validacao;

use MrPrompt\Cielo\Enum\Cliente\Documento;
use MrPrompt\Cielo\Enum\Cliente\Status;
use Respect\Validation\Validator as v;

final class Cliente extends Base
{
   public static function NameValidate($name)
   {
      if (!v::notEmpty()->validate($name)) {
         static::$erros[] = 'Nome inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function StatusValidate($status)
   {
      if (!v::in(Status::status(), true)->validate($status)) {
         static::$erros[] = 'Status inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function IdentityValidate($identity) 
   {
      if (!v::notEmpty()->validate($identity)) {
         static::$erros[] = 'Número de documento inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function IdentityTypeValidate($identityType)
   {
      if (!v::in(Documento::documentos(), true)->validate($identityType)) {
         static::$erros[] = 'Tipo de documento inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function EmailValidate($email) 
   {
      if (!v::notEmpty()->email()->validate($email)) {
         static::$erros[] = 'Email inválido';
     }

     return (bool) sizeof(static::$erros) === 0;
   }

   public static function BirthdateValidate($birthdate)
   {
      $referencia = new \DateTime;

      if ($birthdate >= $referencia) {
         static::$erros[] = 'Data de nascimento inválida.';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function AddressValidate($address) {}

   public static function DeliveryAddressValidate($delivery) {}

   public static function BillingValidate($billing) {}
}
