<?php

require_once __DIR__ . '/../bootstrap.php';

use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;
use MrPrompt\Cielo\Enum\Pagamento\Tipo as PagamentoTipo;
use MrPrompt\Cielo\Enum\Cliente\Status as ClienteStatus;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as EnderecoTipo;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;
use MrPrompt\Cielo\Enum\Pagamento\Provedor as ProvedorTipo;
use MrPrompt\Cielo\Recursos\Boleto\Pagamento;
use MrPrompt\Cielo\Exceptions\CieloApiErrors;

$clienteDto = ClienteDto::fromArray([
    'nome' => 'John Doe',
    'status' => ClienteStatus::NOVO->value,
    'documento' => [
        'numero' => '12345678900',
        'tipo' => 'CPF'
    ],
    'endereco' => [
        'tipo' => EnderecoTipo::RESIDENCIAL->value,
        'numero' => '123',
        'endereco' => 'Main St',
        'cidade' => 'Anytown',
        'estado' => Estado::SC->value,
        'cep' => '12345',
        'pais' => Pais::BRASIL->value,
        'bairro' => 'Centro',
    ],
    'cobranca' => [
        'tipo' => EnderecoTipo::COBRANCA->value,
        'endereco' => 'Oak St',
        'numero' => '789',
        'cidade' => 'Sometown',
        'estado' => Estado::SC->value,
        'cep' => '11223',
        'pais' => Pais::BRASIL->value,
        'bairro' => 'Centro',
    ],
]);

$pagamentoDto = PagamentoDto::fromArray([
    'tipo' => PagamentoTipo::BOLETO->value,
    'valor' => 1000,
    'provedor' => ProvedorTipo::BANCO_DO_BRASIL->value,
]);

try {
    echo "Efetuando pagamento do tipo: BOLETO\n";
    
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
