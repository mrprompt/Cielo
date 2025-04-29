<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;

class ZeroAuth implements Dto
{
    public function __construct(
        public ?bool $valido = null,
        public ?string $codigo = null,
        public ?string $mensagem = null,
        public ?string $identificador = null
    ) { }

    public static function fromRequest(object $request): self
    {
        return new self(
           valido: $request->Valid ?? null,
           codigo: $request->ReturnCode ?? null,
           mensagem: $request->ReturnMessage ?? null,
           identificador: $request->IssuerTransactionId ?? null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            valido: $data['valido'] ?? null,
            codigo: $data['codigo'] ?? null,
            mensagem: $data['mensagem'] ?? null,
            identificador: $data['identificador'] ?? null
        );
    }

    public function toRequest(): array 
    {
        return [];
    }
}
