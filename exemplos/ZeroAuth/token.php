<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Recursos\ZeroAuth\Token;

$dados = [
    'valido' => [
        'cartao' => '5502095822650000',
        'token' => '55187c47-4b18-45a7-843c-6b0c9a6e9e46',
    ],
    'valido' => [
        'cartao' => '5315281703921200',
        'token' => '8d5c55c0-f068-44c5-9dbb-e2c5c1f9ad41',
    ],
];

foreach ($dados as $status => $dados) {
    echo "Consultando token: {$dados['token']} - Status esperado: {$status}\n";
    
    try {
        $zeroAuthToken = new Token($driver);
        $result = $zeroAuthToken->__invoke(CartaoDto::fromArray([
            'tipo' => TipoCartao::CREDITO->value,
            'bandeira' => BandeiraCartao::VISA->value,
            'token' => $dados['token'],
        ]));

        $mensagens = [
            "\tVálido: {$result->valido}",
            "\tCódigo: {$result->codigo}",
            "\tMensagem: {$result->mensagem}",
            "\tIdentificador: {$result->identificador}",
            "\tJSON enviado: {$zeroAuthToken->jsonEnvio}",
            "\tJSON recebido: {$zeroAuthToken->jsonRecebimento}",
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
