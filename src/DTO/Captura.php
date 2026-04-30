<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;

class Captura implements Dto
{
    public function __construct(
        public readonly int|string $status,
        public readonly int|string $motivoCodigo,
        public readonly string $motivoMensagem,
        public readonly int|string $retornoCodigoProvedor,
        public readonly string $retornoMensagemProvedor,
        public readonly int|string $retornoCodigo,
        public readonly string $retornoMensagem,
        public readonly string $tid,
        public readonly string $comprovante,
        public readonly string $autorizacao,
    ) {}

    public static function fromRequest(object $request): static
    {
        return new static(
            status: $request->Status ?? '',
            motivoCodigo: $request->ReasonCode ?? '',
            motivoMensagem: $request->ReasonMessage ?? '',
            retornoCodigoProvedor: $request->ProviderReturnCode ?? '',
            retornoMensagemProvedor: $request->ProviderReturnMessage ?? '',
            retornoCodigo: $request->ReturnCode ?? '',
            retornoMensagem: $request->ReturnMessage ?? '',
            tid: $request->Tid ?? '',
            comprovante: $request->ProofOfSale ?? '',
            autorizacao: $request->AuthorizationCode ?? '',
        );
    }

    public static function fromArray(array $data): static
    {
        return new static(
            status: $data['status'] ?? '',
            motivoCodigo: $data['motivoCodigo'] ?? '',
            motivoMensagem: $data['motivoMensagem'] ?? '',
            retornoCodigoProvedor: $data['retornoCodigoProvedor'] ?? '',
            retornoMensagemProvedor: $data['retornoMensagemProvedor'] ?? '',
            retornoCodigo: $data['retornoCodigo'] ?? '',
            retornoMensagem: $data['retornoMensagem'] ?? '',
            tid: $data['tid'] ?? '',
            comprovante: $data['comprovante'] ?? '',
            autorizacao: $data['autorizacao'] ?? '',
        );
    }

    public function toRequest(): array
    {
        return [];
    }
}
