<?php 

namespace MrPrompt\Cielo\Enum\Pagamento;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Tipo: string 
{
    case CARTAO_DE_CREDITO = 'CreditCard';
    case CARTAO_DE_DEBITO = 'DebitCard';
    case BOLETO = 'Boleto';
    case PIX = 'Pix';

    public static function match(string $tipo): self
    {
        return match ($tipo) {
            self::CARTAO_DE_CREDITO->value => self::CARTAO_DE_CREDITO,
            self::CARTAO_DE_DEBITO->value => self::CARTAO_DE_DEBITO,
            self::BOLETO->value => self::BOLETO,
            self::PIX->value => self::PIX,
            default => throw new ValidacaoErrors("Tipo de pagamento inválido: {$tipo}")
        };
    }

    public static function pagamentos(): array
    {
        return array_column(self::cases(), 'value');
    }
}
