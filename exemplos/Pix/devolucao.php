<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Recursos\Pix\Devolucao;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;

try {
    echo "Efetuando uma devolução de PXI\n";

    $pagamentoDto = PagamentoDto::fromArray([
        'id' => uniqid(),
        'valor' => 1000,
    ]);

    $cancelamento = new Devolucao($driver);
    
    /**
     * @result CancelamentoDto $result
     */
    $result = $cancelamento($ordemDto, $pagamentoDto);

    $mensagens = [
        "\tStatus: {$result->status}",
        "\tTid: {$result->tid}",
        "\tRetorno: {$result->retornoMensagem}",
        "\tJSON enviado: {$cancelamento->jsonEnvio}",
        "\tJSON recebido: {$cancelamento->jsonRecebimento}",
    ];

    echo implode("\n", $mensagens);
    echo "\n\n";

    unset($pagamento, $result, $cancelamento, $resultPagamentoComCaptura);

    echo "Efetuando cancelamento por: Pagamento\n";

    $ordemDto = new OrdemDto(uniqid());
    $pagamento = new Pagamento($driver);

    /**
     * @var TransacaoDto $resultPagamentoComCaptura
     */
    $resultPagamentoComCaptura = $pagamento($ordemDto, $clienteDto, $pagamentoDto);
    
    $cancelamento = new CancelamentoPaymentId($driver);
    
    /**
     * @result CancelamentoDto $result
     */
    $result = $cancelamento($resultPagamentoComCaptura->pagamento);

    $mensagens = [
        "\tStatus: {$result->status}",
        "\tTid: {$result->tid}",
        "\tRetorno: {$result->retornoMensagem}",
        "\tJSON enviado: {$cancelamento->jsonEnvio}",
        "\tJSON recebido: {$cancelamento->jsonRecebimento}",
    ];

    echo implode("\n", $mensagens);
} catch (CieloApiErrors $ex) {
    echo "\t" . $ex->getMessage() . "\n";
    echo "\t\terros: \n";

    foreach ($ex->erros as $erro) {
        echo "\t\t\t - " . $erro->Code . ': ' . $erro->Message . "\n";
    }
}
