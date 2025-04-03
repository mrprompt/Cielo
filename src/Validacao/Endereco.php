<?php

namespace MrPrompt\Cielo\Validacao;

use MrPrompt\Cielo\Enum\Cliente\Endereco as EnderecoEnum;
use Respect\Validation\Validator as v;

final class Endereco extends Base
{
   public static function StreetValidate($input)
   {
      if (!v::notEmpty()->validate($input)) {
         static::$erros[] = 'Endereço inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function NumberValidate($input)
   {
      if (!v::digit()->validate($input)) {
         static::$erros[] = 'Número de endereço inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function ComplementValidate($input)
   {
      return (bool) sizeof(static::$erros) === 0;
   }

   public static function ZipCodeValidate($input)
   {
      if (!v::digit()->notEmpty()->validate($input)) {
         static::$erros[] = 'CEP inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function CityValidate($input)
   {
      if (!v::notEmpty()->validate($input)) {
         static::$erros[] = 'Cidade inválida';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function StateValidate($input)
   {
      if (!v::notEmpty()->validate($input)) {
         static::$erros[] = 'Estado inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function CountryValidate($input)
   {
      if (!v::notEmpty()->validate($input)) {
         static::$erros[] = 'País inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }
}
