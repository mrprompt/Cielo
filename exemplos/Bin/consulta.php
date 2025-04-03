<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Bin as BinDto;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\Validacao\Bin as BinValidator;

$consulta = new MrPrompt\Cielo\Recursos\Bin\Consulta($driver);
$dados = [
    'valido' => '5502095822650000',
    'invalido_1' => '4512210012341234',
    'invalido_2' => '',
    'invalido_3' => '12345677890',
];

foreach ($dados as $status => $cartao) {
    echo "Consultando bin {$status}: {$cartao}\n";
    
    try {
        $binDto = BinDto::fromArray(['numero' => $cartao]);
        
        // validação
        BinValidator::validate($binDto);

        $result = $consulta($binDto);

        $mensagens = [
            "\tStatus: {$result->status}",
            "\tEmissor: {$result->emissorNome}",
            "\tBandeira: {$result->bandeira->value}",
            "\tJSON enviado: {$consulta->jsonEnvio}",
            "\tJSON recebido: {$consulta->jsonRecebimento}",
        ];

        echo implode("\n", $mensagens);
    } catch (CieloApiErrors $ex) {
        echo "\t" . $ex->getMessage() . "\n";
        echo "\tErros da API: \n";
        
        foreach ($ex->erros as $erro) {
            echo "\t\t - " . $erro->Code . ': ' . $erro->Message . "\n";
        }
    } catch (ValidacaoErrors $ex) {
        echo "\t" . $ex->getMessage() . "\n";
        echo "\tErros de validação: \n";

        foreach ($ex->erros as $erro) {
            echo "\t\t - " . $erro->Code . ': ' . $erro->Message . "\n";
        }
    } catch (InvalidArgumentException $ex) {
        echo "\t" . $ex->getMessage() . "\n";
    }

    echo "\n\n";
}
