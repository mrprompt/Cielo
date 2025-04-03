<?php

namespace MrPrompt\Cielo\Validacao;

use MrPrompt\Cielo\Enum\Cliente\Documento as DocumentoEnum;
use Respect\Validation\Validator as v;

final class Documento extends Base
{
   public static function IdentityValidate($identity)
   {
      if (!v::digit()->notBlank()->validate($identity)) {
         static::$erros[] = 'Número de documento inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }

   public static function IdentityTypeValidate($identityType)
   {
      if (!v::in(DocumentoEnum::documentos(), true)->validate($identityType)) {
         static::$erros[] = 'Tipo de documento inválido';
      }

      return (bool) sizeof(static::$erros) === 0;
   }
}
