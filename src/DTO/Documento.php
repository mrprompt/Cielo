<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Cliente\Documento as DocumentoTipo;

class Documento implements Dto
{
    public function __construct(public readonly DocumentoTipo $tipo, public readonly string $numero) {}

    public static function fromRequest($request): self
    {
        return new self(
            tipo: $request->IdentityType ? DocumentoTipo::match($request->IdentityType) : null,
            numero: $request->Identity
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tipo: DocumentoTipo::match($data['tipo']),
            numero: $data['numero']
        );
    }

    public function toRequest(): array
    {
        return array_filter([
            'Identity' => $this->numero,
            'IdentityType' => $this->tipo->value,
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
