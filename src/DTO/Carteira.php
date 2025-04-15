<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Carteira\Tipo;

class Carteira implements Dto
{
    public function __construct(
        public ?Tipo $tipo = null, 
        public ?string $cavv = null, 
        public ?string $eci = null, 
        public ?string $chave = null)
    {}

    public static function fromRequest($request): self
    {
        return new self(
            tipo: $request->Type ?? null,
            cavv: $request->Cavv ?? null,
            eci: $request->Eci ?? null,
            chave: $request->WalletKey ?? null
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tipo: Tipo::match($data['tipo']),
            cavv: $data['cavv'] ?? null,
            eci: $data['eci'] ?? null,
            chave: $data['chave'] ?? null,
        );
    }

    public function toRequest(): array
    {
        return array_filter([
            'Type' => $this->tipo->value,
            'Cavv' => $this->cavv,
            'Eci' => $this->eci,
            'WalletKey' => $this->chave,
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
