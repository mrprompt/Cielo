<?php

namespace MrPrompt\Cielo\Recursos\Cartao;

use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Captura as CapturaDto;

class Captura
{
    private const URI = '1/sales/{PaymentId}/capture?amount={Amount}';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(PagamentoDto $pagamento): CapturaDto
    {
        $url = self::URI;

        if ($pagamento->taxas) {
            $url .= '&serviceTaxAmount={ServiceTaxAmount}';
        }

        $body = [$pagamento->id, $pagamento->valor, $pagamento->taxas];
        $url = str_replace(['{PaymentId}', '{Amount}', '{ServiceTaxAmount}'], $body, $url);

        $result =  $this->driver->put($url, []);
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = CapturaDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
