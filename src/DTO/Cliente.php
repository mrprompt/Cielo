<?php

namespace MrPrompt\Cielo\DTO;

use DateTime;
use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\DTO\Documento;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as TipoEndereco;

class Cliente implements Dto
{
    public function __construct(
        public string $nome,
        public ?Status $status = null,
        public Documento $documento,
        public ?string $email = null,
        public ?DateTime $nascimento = null,
        public ?Endereco $endereco = null,
        public ?Endereco $entrega = null,
        public ?Endereco $cobranca = null
    ) {}

    public static function fromRequest(object $request): self
    {
        return new self(
            nome: $request->Name ?? null,
            status: property_exists($request, 'Status') ? Status::match($request->Status) : null,
            documento: Documento::fromRequest($request),
            email: $request->Email ?? null,
            nascimento: property_exists($request, 'Birthdate') ? new DateTime($request->Birthdate) : null,
            endereco: property_exists($request, 'Address') ? Endereco::fromRequest($request->Address, TipoEndereco::RESIDENCIAL) : null,
            entrega: property_exists($request, 'DeliveryAddress') ? Endereco::fromRequest($request->DeliveryAddress, TipoEndereco::ENTREGA) : null,
            cobranca: property_exists($request, 'Billing') ? Endereco::fromRequest($request->Billing, TipoEndereco::COBRANCA) : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nome: $data['nome'],
            status: array_key_exists('status', $data) ? Status::match($data['status']) : null,
            documento: Documento::fromArray($data['documento']),
            email: $data['email'] ?? null,
            nascimento: array_key_exists('nascimento', $data) ? new DateTime($data['nascimento']) : null,
            endereco: array_key_exists('endereco', $data) ? Endereco::fromArray($data['endereco'], TipoEndereco::RESIDENCIAL) : null,
            entrega: array_key_exists('entrega', $data) ? Endereco::fromArray($data['entrega'], TipoEndereco::ENTREGA) : null,
            cobranca: array_key_exists('cobranca', $data) ? Endereco::fromArray($data['cobranca'], TipoEndereco::COBRANCA) : null
        );
    }

    public function toRequest(): array
    {
        return array_filter(
            array_merge(
                [
                    'Name' => $this->nome,
                    'Status' => !is_null($this->status) ? $this->status->value : null,
                    'Identity' => $this->documento->numero,
                    'IdentityType' => $this->documento->tipo->value,
                    'Email' => $this->email,
                    'Birthdate' => !is_null($this->nascimento) ? $this->nascimento->format('Y-m-d') : null,
                ],
                !is_null($this->endereco) ? ['Address' => $this->endereco->toRequest()] : [],
                !is_null($this->entrega) ? ['DeliveryAddress' => $this->entrega->toRequest()] : [],
                !is_null($this->cobranca) ? ['Billing' => $this->cobranca->toRequest()] : [],
            ),
            fn($value) => !is_null($value) && $value !== ''
        );
    }
}
