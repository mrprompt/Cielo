<?php

namespace MrPrompt\Cielo\Recursos\Cartao;

use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Pagamento as PagamentoDto;
use MrPrompt\Cielo\DTO\Cancelamento as CancelamentoDto;

class CancelamentoPaymentId
{
    private const URI = '1/sales/{PaymentId}/void?amount={Amount}';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(PagamentoDto $pagamento): CancelamentoDto
    {
        $body = [$pagamento->id, $pagamento->valor];
        $url = str_replace(['{PaymentId}', '{Amount}'], $body, self::URI);

        $result =  $this->driver->put($url, []);
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = CancelamentoDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
