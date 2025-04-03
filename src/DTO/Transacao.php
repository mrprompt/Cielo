<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;

class Transacao implements Dto
{
    public function __construct(public readonly Ordem $ordem, public readonly Cliente $cliente, public readonly Pagamento $pagamento) {}

    public static function fromRequest(object $request): self
    {
        return new self(
            ordem: Ordem::fromRequest($request),
            cliente: Cliente::fromRequest($request->Customer),
            pagamento: Pagamento::fromRequest($request->Payment),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            ordem: Ordem::fromArray($data['ordem']),
            cliente: Cliente::fromArray($data['cliente']),
            pagamento: Pagamento::fromArray($data['pagamento']),
        );
    }

    public function toRequest(): array
    {
        return array_filter(array_merge(
            $this->ordem->toRequest(),
            ['Customer' => $this->cliente->toRequest()],
            ['Payment' => $this->pagamento->toRequest()],
        ), fn($value) => !is_null($value) && $value !== '');
    }
}
