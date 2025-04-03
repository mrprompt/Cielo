<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Carteira\Tipo;

class Carteira implements Dto
{
    public function __construct(public Tipo $tipo, public string $cavv, public string $eci)
    {}

    public static function fromRequest($request): self
    {
        return new self(
            tipo: $request->Type,
            cavv: $request->Cavv,
            eci: $request->Eci
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tipo: Tipo::match($data['tipo']),
            cavv: $data['cavv'],
            eci: $data['eci']
        );
    }

    public function toRequest(): array
    {
        return array_filter([
            'Type' => $this->tipo->value,
            'Cavv' => $this->cavv,
            'Eci' => $this->eci,
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
