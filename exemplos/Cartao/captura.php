<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\DTO\Captura as CapturaDto;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Enum\Cliente\Endereco as EnderecoTipo;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Pagamento\Moeda as MoedaTipo;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Enum\Cartao\Tipo as CartaoTipo;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as CartaoBandeira;
use MrPrompt\Cielo\Enum\Cliente\Estado;
use MrPrompt\Cielo\Enum\Cliente\Pais;
use MrPrompt\Cielo\Recursos\Cartao\Pagamento;
use MrPrompt\Cielo\Recursos\Cartao\Captura;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;
use MrPrompt\Cielo\Validacao\Pagamento as PagamentoValidate;

try {
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
        'endereco' => [
            'tipo' => EnderecoTipo::RESIDENCIAL->value,
            'endereco' => '123 Main St',
            'cidade' => 'Anytown',
            'estado' => Estado::SC->value,
            'cep' => '12345',
            'pais' => Pais::BRASIL->value,
        ],
        'entrega' => [
            'tipo' => EnderecoTipo::ENTREGA->value,
            'endereco' => '456 Elm St',
            'cidade' => 'Othertown',
            'estado' => Estado::SC->value,
            'cep' => '67890',
            'pais' => Pais::BRASIL->value,
        ],
        'cobranca' => [
            'tipo' => EnderecoTipo::COBRANCA->value,
            'endereco' => '789 Oak St',
            'cidade' => 'Sometown',
            'estado' => Estado::SC->value,
            'cep' => '11223',
            'pais' => Pais::BRASIL->value,
        ],
    ]);

    $pagamentoDto = PagamentoDto::fromArray([
        'tipo' => PagamentoTipo::CARTAO_DE_CREDITO->value,
        'valor' => 1000,
        'moeda' => MoedaTipo::REAL->value,
        'provedor' => ProvedorTipo::CIELO->value,
        'descricao' => 'no nonono nonono',
        'parcelas' => 1,
        'captura' => false,
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

    $pagamentoSemCaptura = new Pagamento($driver);

    /**
     * @var TransacaoDto $resultPagamentoSemCaptura
     */
    $resultPagamentoSemCaptura = $pagamentoSemCaptura($ordemDto, $clienteDto, $pagamentoDto);

    // Preparando a captura
    $capturaDto = PagamentoDto::fromArray([
        'id' => $resultPagamentoSemCaptura->pagamento->id,
        'valor' => $resultPagamentoSemCaptura->pagamento->valor,
        'taxas' => $resultPagamentoSemCaptura->pagamento->taxas,
    ]);
    
    // validação
    PagamentoValidate::validate($capturaDto);

    $captura = new Captura($driver);

    /**
     * @result CapturaDto $result
     */
    $result = $captura($capturaDto);

    $mensagens = [
        "\tStatus: {$result->status}",
        "\tMensagem: {$result->motivoMensagem}",
        "\tRetorno: {$result->retornoMensagemProvedor}",
        "\tJSON enviado: {$captura->jsonEnvio}",
        "\tJSON recebido: {$captura->jsonRecebimento}",
    ];

    echo implode("\n", $mensagens);
} catch (CieloApiErrors $ex) {
    echo "\t" . $ex->getMessage() . "\n";
    echo "\t\terros: \n";

    foreach ($ex->erros as $erro) {
        echo "\t\t\t - " . $erro->Code . ': ' . $erro->Message . "\n";
    }
}
