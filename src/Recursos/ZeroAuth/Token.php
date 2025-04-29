<?php

namespace MrPrompt\Cielo\Recursos\ZeroAuth;

use MrPrompt\Cielo\Infra\HttpDriver;
use MrPrompt\Cielo\DTO\Cartao as CartaoDto;
use MrPrompt\Cielo\DTO\ZeroAuth as ZeroAuthDto;

class Token
{
    private const URI = '1/zeroauth/';

    public readonly string $jsonEnvio;
    public readonly string $jsonRecebimento;

    public function __construct(private readonly HttpDriver $driver) {}

    public function __invoke(CartaoDto $cartao, bool $save = false): ZeroAuthDto
    {
        $body = [
            'CardToken' => $cartao->token,
            'Brand' => $cartao->bandeira->value,
            'SaveCard' => $save,
        ];

        $result = $this->driver->post(self::URI, $body);
        $json = strval($result->getBody());

        $this->jsonEnvio = json_encode($body);
        $this->jsonRecebimento = $json;

        $daoResult = ZeroAuthDto::fromRequest(json_decode($json));

        return $daoResult;
    }
}
