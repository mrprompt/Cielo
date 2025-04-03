<?php

namespace MrPrompt\Cielo\Recursos\Bin;

use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Bin as BinDto;

class Consulta
{
    private const URI = '1/cardBin/{BIN}';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(BinDto $bin): BinDto
    {
        $body = $bin->toRequest();
        $numero = $body['CardNumber'];
        $result = $this->driver->get(str_replace('{BIN}', $numero, self::URI));
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = BinDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
