<?php

namespace MrPrompt\Cielo\Enum\Bin;

enum Status: string
{
    case ANALISE_AUTORIZADA = '00';
    case BANDEIRA_NAO_SUPORTADA = '01';
    case CARTAO_NAO_SUPORTADO = '02';
    case AFILIACAO_BLOQUEADA = '73';

    public function label(): string
    {
        return match ($this) {
            self::ANALISE_AUTORIZADA => 'Análise autorizada ',
            self::BANDEIRA_NAO_SUPORTADA => 'Bandeira não suportada ',
            self::CARTAO_NAO_SUPORTADO => 'Cartão não suportado na consulta de bin ',
            self::AFILIACAO_BLOQUEADA => 'Afiliação bloqueada',
            default => throw new \InvalidArgumentException("Label não encontrado"),
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ANALISE_AUTORIZADA => 'Análise autorizada ',
            self::BANDEIRA_NAO_SUPORTADA => 'Bandeira não suportada ',
            self::CARTAO_NAO_SUPORTADO => 'Cartão não suportado na consulta de bin ',
            self::AFILIACAO_BLOQUEADA => 'Afiliação bloqueada',
            default => throw new \InvalidArgumentException("Descrição não encontrada"),
        };
    }

    public static function status(): array
    {
        return array_column(self::cases(), 'value');
    }
}
