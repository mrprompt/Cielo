<?php

namespace MrPrompt\Cielo\Enum\Localizacao;

use MrPrompt\Cielo\Exceptions\ValidacaoErrors;

enum Estado: string
{
    case AC = 'AC';
    case AL = 'AL';
    case AP = 'AP';
    case AM = 'AM';
    case BA = 'BA';
    case CE = 'CE';
    case DF = 'DF';
    case ES = 'ES';
    case GO = 'GO';
    case MA = 'MA';
    case MT = 'MT';
    case MS = 'MS';
    case MG = 'MG';
    case PA = 'PA';
    case PB = 'PB';
    case PR = 'PR';
    case PE = 'PE';
    case PI = 'PI';
    case RJ = 'RJ';
    case RN = 'RN';
    case RS = 'RS';
    case RO = 'RO';
    case RR = 'RR';
    case SC = 'SC';
    case SP = 'SP';
    case SE = 'SE';
    case TO = 'TO';

    public static function match(string $estado): self
    {
        return match ($estado) {
            'AC' => self::AC,
            'AL' => self::AL,
            'AP' => self::AP,
            'AM' => self::AM,
            'BA' => self::BA,
            'CE' => self::CE,
            'DF' => self::DF,
            'ES' => self::ES,
            'GO' => self::GO,
            'MA' => self::MA,
            'MT' => self::MT,
            'MS' => self::MS,
            'MG' => self::MG,
            'PA' => self::PA,
            'PB' => self::PB,
            'PR' => self::PR,
            'PE' => self::PE,
            'PI' => self::PI,
            'RJ' => self::RJ,
            'RN' => self::RN,
            'RS' => self::RS,
            'RO' => self::RO,
            'RR' => self::RR,
            'SC' => self::SC,
            'SP' => self::SP,
            'SE' => self::SE,
            'TO' => self::TO,
            default => throw new ValidacaoErrors("Estado inválido: {$estado}"),
        };
    }

    public static function estados(): array
    {
        return array_column(self::cases(), 'value');
    }
}
