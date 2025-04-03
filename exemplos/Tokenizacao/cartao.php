<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Recursos\Tokenizacao\Cartao;

$dados = [
    'valido_1' => '5502095822650000',
    'valido_2' => '5315281703921200',
    'invalido' => '5512210012341209'
];

foreach ($dados as $status => $cartao) {
    echo "Tokenizando cartão: {$cartao} - Status esperado: {$status}\n";
    
    try {
        $tokenizacao = new Cartao($driver);
        $result = $tokenizacao->__invoke(CartaoDto::fromArray([
            'tipo' => TipoCartao::CREDITO->value,
            'bandeira' => BandeiraCartao::VISA->value,
            'numero' => $cartao,
            'validade' => '12/2030',
            'portador' => 'Fulano de Tal',
            'nome' => 'Fulano de Tal',
        ]));

        $mensagens = [
            "\tToken: {$result->token}",
            "\tJSON enviado: {$tokenizacao->jsonEnvio}",
            "\tJSON recebido: {$tokenizacao->jsonRecebimento}",
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
