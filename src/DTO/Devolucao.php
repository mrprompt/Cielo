<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;

class Devolucao implements Dto
{
    public function __construct(
        public readonly int $status,
        public readonly string $motivoCodigo,
        public readonly string $motivoMensagem,
        public readonly string $retornoCodigo,
        public readonly string $retornoMensagem,
    ) {}

    public static function fromRequest(object $request): self
    {
        return new self(
            status: $request->Status ?? '',
            motivoCodigo: $request->ReasonCode ?? '',
            motivoMensagem: $request->ReasonMessage ?? '',
            retornoCodigo: $request->ReturnCode ?? '',
            retornoMensagem: $request->ReturnMessage ?? '',
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'] ?? '',
            motivoCodigo: $data['motivoCodigo'] ?? '',
            motivoMensagem: $data['motivoMensagem'] ?? '',
            retornoCodigo: $data['retornoCodigo'] ?? '',
            retornoMensagem: $data['retornoMensagem'] ?? '',
        );
    }

    public function toRequest(): array
    {
        return [];
    }
}
