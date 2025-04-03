<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\DTO\Carteira as CarteiraDto;
use MrPrompt\Cielo\Enum\Carteira\Tipo as TipoCarteira;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Recursos\ZeroAuth\Carteira;

$dados = [
    'valido_1' => '4532154371691902',
    'invalido' => '4512210012341234'
];

foreach ($dados as $status => $cartao) {
    echo "Consultando cartão: {$cartao} - Status esperado: {$status}\n";
    
    try {
        $zeroAuthCarteira = new Carteira($driver);
        $result = $zeroAuthCarteira->__invoke(
            CartaoDto::fromArray([
                'tipo' => TipoCartao::CREDITO->value,
                'bandeira' => BandeiraCartao::VISA->value,
                'numero' => $cartao,
                'validade' => '112/2032',
                'codigoSeguranca' => '333',
                'portador' => 'Joao da Silva',
            ]),
            CarteiraDto::fromArray([
                'tipo' => TipoCarteira::APPLE_PAY->value,
                'cavv' => 'AM1mbqehL24XAAa0J04CAoABFA==',
                'eci' => '7',
            ])
        );

        $mensagens = [
            "\tVálido: {$result->valido}",
            "\tCódigo: {$result->codigo}",
            "\tMensagem: {$result->mensagem}",
            "\tIdentificador: {$result->identificador}",
            "\tJSON enviado: {$zeroAuthCarteira->jsonEnvio}",
            "\tJSON recebido: {$zeroAuthCarteira->jsonRecebimento}",
        ];

        echo implode("\n", $mensagens);
    } catch (CieloApiErrors $ex) {
        echo "\t" . $ex->getMessage() . "\n";
        echo "\t\terros: \n";

        foreach ($ex->erros as $erro) {
            echo "\t\t\t - " . $erro->Code . ': ' . $erro->Message . "\n";
        }
    }

    echo "\n\n";
}
