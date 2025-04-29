<?php

namespace MrPrompt\Cielo\Recursos\Carne;

use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;
use MrPrompt\Cielo\DTO\Transacao as TransacaoDto;

class Pagamento
{
    private const URI = '1/sales/';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(OrdemDto $ordem, ClienteDto $cliente, PagamentoDto $pagamento): TransacaoDto
    {
        $body = array_merge(
            $ordem->toRequest(),
            ['Customer' => $cliente->toRequest()],
            ['Payment' => $pagamento->toRequest()],
        );

        $result = $this->driver->post(self::URI, $body);
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = TransacaoDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
