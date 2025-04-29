<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Recursos\ZeroAuth\Cartao;

$dados = [
    'valido_1' => '5502095822650000',
    'valido_2' => '5315281703921200',
    'invalido' => '4512210012341234'
];

foreach ($dados as $status => $cartao) {
    echo "Consultando cartão: {$cartao} - Status esperado: {$status}\n";
    
    try {
        $zeroAuthCartao = new Cartao($driver);
        $result = $zeroAuthCartao->__invoke(CartaoDto::fromArray([
            'tipo' => TipoCartao::CREDITO->value,
            'bandeira' => BandeiraCartao::VISA->value,
            'numero' => $cartao,
            'validade' => '12/2023',
            'indicador' => '1',
            'codigoSeguranca' => '123',
            'portador' => 'Fulano de Tal',
            'token' => null,
        ]));

        $mensagens = [
            "\tVálido: {$result->valido}",
            "\tCódigo: {$result->codigo}",
            "\tMensagem: {$result->mensagem}",
            "\tIdentificador: {$result->identificador}",
            "\tJSON enviado: {$zeroAuthCartao->jsonEnvio}",
            "\tJSON recebido: {$zeroAuthCartao->jsonRecebimento}",
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
