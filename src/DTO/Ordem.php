<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;

class Ordem implements Dto
{
    public function __construct(public readonly string $identificador) {}

    public static function fromRequest(object $request): self
    {
        return new self(
            identificador: $request->MerchantOrderId
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            identificador: $data['identificador']
        );
    }

    public function toRequest(): array
    {
        return [
            'MerchantOrderId' => $this->identificador,
        ];
    }
}
