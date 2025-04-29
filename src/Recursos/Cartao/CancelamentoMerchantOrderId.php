<?php

namespace MrPrompt\Cielo\Recursos\Cartao;

use MrPrompt\Cielo\DTO\Cancelamento as CancelamentoDto;
use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Ordem as OrdemDto;

class CancelamentoMerchantOrderId
{
    private const URI = '1/sales/OrderId/{MerchantOrderId}/void?amount={Amount}';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(OrdemDto $ordem, PagamentoDto $pagamento): CancelamentoDto
    {
        $body = [$ordem->identificador, $pagamento->valor];
        $url = str_replace(['{MerchantOrderId}', '{Amount}'], $body, self::URI);

        $result =  $this->driver->put($url, []);
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = CancelamentoDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
