<?php

namespace MrPrompt\Cielo\Enum\Status;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Transacao: string
{
    case NOT_FINISHED = '0';
    case AUTHORIZED = '1';
    case PAYMENT_CONFIRMED = '2';
    case DENIED = '3';
    case VOIDED = '10';
    case REFUNDED = '11';
    case PENDING = '12';
    case ABORTED = '13';
    case SCHEDULED = '20';

    public static function match(string|int $status): self
    {
        return match ((string) $status) {
            self::ABORTED->value => self::ABORTED,
            self::NOT_FINISHED->value => self::NOT_FINISHED,
            self::AUTHORIZED->value => self::AUTHORIZED,
            self::PAYMENT_CONFIRMED->value => self::PAYMENT_CONFIRMED,
            self::DENIED->value => self::DENIED,
            self::VOIDED->value => self::VOIDED,
            self::REFUNDED->value => self::REFUNDED,
            self::PENDING->value => self::PENDING,
            self::SCHEDULED->value => self::SCHEDULED,
            default => throw new ValidacaoErrors("Status inválido: {$status}")
        };
    }

    public static function status(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function descricao(): string
    {
        return match ($this) {
            self::NOT_FINISHED => 'Aguardando atualização de status.',
            self::AUTHORIZED => 'Pagamento apto a ser capturado ou definido como pago.',
            self::PAYMENT_CONFIRMED => 'Pagamento confirmado e finalizado.',
            self::DENIED => 'Pagamento negado por Autorizador.',
            self::VOIDED => 'Pagamento cancelado.',
            self::REFUNDED => 'Pagamento cancelado após 23h59 do dia de autorização.',
            self::PENDING => 'Aguardando retorno da instituição financeira.',
            self::ABORTED => 'Pagamento cancelado por falha no processamento ou por ação do Antifraude.',
            self::SCHEDULED => 'Recorrência agendada.'
        };
    }
    
}
