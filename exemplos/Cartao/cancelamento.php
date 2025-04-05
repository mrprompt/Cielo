<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\DTO\Captura as CapturaDto;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as EnderecoTipo;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Pagamento\Moeda as MoedaTipo;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Enum\Cartao\Tipo as CartaoTipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as CartaoBandeira;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;
use MrPrompt\Cielo\Recursos\Cartao\Pagamento;
use MrPrompt\Cielo\Recursos\Cartao\CancelamentoMerchantOrderId;
use MrPrompt\Cielo\Recursos\Cartao\CancelamentoPaymentId;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Validacao\Pagamento as PagamentoValidate;
use MrPrompt\Cielo\Validacao\Ordem as OrdemValidate;

try {
    echo "Efetuando cancelamento por: Ordem\n";

    $ordemDto = new OrdemDto(uniqid());

    $clienteDto = ClienteDto::fromArray([
        'nome' => 'John Doe',
        'status' => Status::NOVO->value,
        'documento' => [
            'numero' => '12345678900',
            'tipo' => 'CPF'
        ],
        'email' => 'john.doe@example.com',
        'nascimento' => '1980-01-01',
        'enderecos' => [
            'principal' => [
                'endereco' => '123 Main St',
                'cidade' => 'Anytown',
                'estado' => Estado::SC->value,
                'cep' => '12345',
                'pais' => Pais::BRASIL->value,
            ],
            'entrega' => [
                'endereco' => '456 Elm St',
                'cidade' => 'Othertown',
                'estado' => Estado::SC->value,
                'cep' => '67890',
                'pais' => Pais::BRASIL->value,
            ],
            'cobranca' => [
                'endereco' => '789 Oak St',
                'cidade' => 'Sometown',
                'estado' => Estado::SC->value,
                'cep' => '11223',
                'pais' => Pais::BRASIL->value,
            ],
        ],
    ]);

    $pagamentoDto = PagamentoDto::fromArray([
        'tipo' => PagamentoTipo::CARTAO_DE_CREDITO->value,
        'valor' => 1000,
        'moeda' => MoedaTipo::REAL->value,
        'provedor' => ProvedorTipo::CIELO->value,
        'descricao' => 'no nonono nonono',
        'parcelas' => 1,
        'captura' => true,
        'autenticacao' => false,
        'recorrente' => false,
        'criptomoeda' => false,
        'cartao' => [
            'tipo' => CartaoTipo::CREDITO->value,
            'bandeira' => CartaoBandeira::VISA->value,
            'numero' => '5502095822650000',
            'validade' => '12/2025',
            'codigoSeguranca' => '123',
            'portador' => 'John Doe',
            'token' => 'token123'
        ],
    ]);

    $pagamento = new Pagamento($driver);

    /**
     * @var TransacaoDto $resultPagamentoComCaptura
     */
    $resultPagamentoComCaptura = $pagamento($ordemDto, $clienteDto, $pagamentoDto);

    $cancelamento = new CancelamentoMerchantOrderId($driver);

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
