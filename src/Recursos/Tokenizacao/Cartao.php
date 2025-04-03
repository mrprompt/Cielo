<?php

namespace MrPrompt\Cielo\Recursos\Tokenizacao;

use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;

class Cartao
{
    private const URI = '1/card/';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(CartaoDto $cartao): CartaoDto
    {
        $body = $cartao->toRequest();

        $result = $this->driver->post(self::URI, $body);
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = CartaoDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
