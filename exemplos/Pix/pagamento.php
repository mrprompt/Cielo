<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Recursos\Pix\Pagamento;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;

$clienteDto = ClienteDto::fromArray([
    'nome' => 'John Doe',
    'documento' => [
        'numero' => '12345678900',
        'tipo' => 'CPF'
    ],
]);

$pagamentoDto = PagamentoDto::fromArray([
    'tipo' => PagamentoTipo::PIX->value,
    'valor' => 1000,
]);

try {
    echo "Efetuando pagamento do tipo: PIX\n";
    
    $pagamento = new Pagamento($driver);
    $ordemDto = new OrdemDto(uniqid());

    /**
     * @var TransacaoDto $result
     */
    $result = $pagamento($ordemDto, $clienteDto, $pagamentoDto);

    $mensagens = [
        "\tPagamento: {$result->pagamento->id}",
        "\tOrdem: {$result->ordem->identificador}",
        "\tCliente: {$result->cliente->nome}",
        "\tJSON enviado: {$pagamento->jsonEnvio}",
        "\tJSON recebido: {$pagamento->jsonRecebimento}",
    ];

    echo implode("\n", $mensagens) . "\n";
} catch (CieloApiErrors $ex) {
    echo "\t" . $ex->getMessage() . "\n";
    echo "\t\terros: \n";

    foreach ($ex->erros as $erro) {
        echo "\t\t\t - " . $erro->Code . ': ' . $erro->Message . "\n";
    }
}
