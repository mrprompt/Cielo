<?php

namespace MrPrompt\Cielo\DTO;

use DateTime;
use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\DTO\Documento;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Enum\Cliente\Endereco as TipoEndereco;

class Cliente implements Dto
{
    public function __construct(
        public string $nome,
        public Status $status,
        public Documento $documento,
        public string $email,
        public DateTime $nascimento,
        public ?Endereco $endereco = null,
        public ?Endereco $entrega = null,
        public ?Endereco $cobranca = null
    ) {}

    public static function fromRequest(object $request): self
    {
        return new self(
            nome: $request->Name,
            status: Status::match($request->Status),
            documento: Documento::fromRequest($request),
            email: $request->Email,
            nascimento: new DateTime($request->Birthdate),
            endereco: property_exists($request, 'Address') ? Endereco::fromRequest($request->Address, TipoEndereco::RESIDENCIAL) : null,
            entrega: property_exists($request, 'DeliveryAddress') ? Endereco::fromRequest($request->DeliveryAddress, TipoEndereco::ENTREGA) : null,
            cobranca: property_exists($request, 'Billing') ? Endereco::fromRequest($request->Billing, TipoEndereco::COBRANCA) : null,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nome: $data['nome'],
            status: Status::match($data['status']),
            documento: Documento::fromArray($data['documento']),
            email: $data['email'],
            nascimento: new DateTime($data['nascimento']),
            endereco: $data['endereco'] ? Endereco::fromArray($data['endereco'], TipoEndereco::RESIDENCIAL) : null,
            entrega: $data['entrega'] ? Endereco::fromArray($data['entrega'], TipoEndereco::ENTREGA) : null,
            cobranca: $data['cobranca'] ? Endereco::fromArray($data['cobranca'], TipoEndereco::COBRANCA) : null
        );
    }

    public function toRequest(): array
    {
        return array_filter(
            array_merge(
                [
                    'Name' => $this->nome,
                    'Status' => $this->status->value,
                    'Identity' => $this->documento->numero,
                    'IdentityType' => $this->documento->tipo->value,
                    'Email' => $this->email,
                    'Birthdate' => $this->nascimento->format('Y-m-d'),
                ],
                ['Address' => $this->endereco->toRequest()],
                ['DeliveryAddress' => $this->entrega->toRequest()],
                ['Billing' => $this->cobranca->toRequest()],
            ),
            fn($value) => !is_null($value) && $value !== ''
        );
    }
}
