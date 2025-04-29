<?php

namespace MrPrompt\Cielo\Enum\Status;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Recorrencia: string

{
    case ACTIVE = '1';
    case FINISHED = '2';
    case DISABLED_BY_MERCHANT = '3';
    case DISABLED_MAX_ATTEMPTS = '4';
    case DISABLED_EXPIRED_CREDIT_CARD = '5';
    case BOLETO_WAITING_CONCILIATION = '6';

    public static function match(string|int $status): self
    {
        foreach (self::cases() as $case) {
            if ($case->value === (string) $status) {
                return $case;
            }
        }

        throw new ValidacaoErrors("Status inválido: {$status}");
    }

    public static function status(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function descricao(): string
    {
        return match ($this) {
            self::ACTIVE => 'Recorrência ativa.',
            self::FINISHED => 'Recorrência finalizada.',
            self::DISABLED_BY_MERCHANT => 'Recorrência desativada pelo comerciante.',
            self::DISABLED_MAX_ATTEMPTS => 'Recorrência desativada por tentativas máximas de cobrança.',
            self::DISABLED_EXPIRED_CREDIT_CARD => 'Recorrência desativada por cartão de crédito expirado.',
            self::BOLETO_WAITING_CONCILIATION => 'Boleto aguardando conciliação.'
        };
    }
}
