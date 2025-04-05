<?php

namespace MrPrompt\Cielo\DTO;

use ArrayObject;
use DateTime;
use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\DTO\Documento;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as TipoEndereco;

class Cliente implements Dto
{
    public function __construct(
        public string $nome,
        public Documento $documento,
        public ?Status $status = null,
        public ?string $email = null,
        public ?DateTime $nascimento = null,
        public ?ArrayObject $enderecos = null,
    ) {}

    public static function fromRequest(object $request): self
    {
        $enderecos = new ArrayObject;
        property_exists($request, 'Address') ?? $enderecos->append(Endereco::fromRequest($request->Address, TipoEndereco::PRINCIPAL));
        property_exists($request, 'DeliveryAddress') ?? $enderecos->append(Endereco::fromRequest($request->DeliveryAddress, TipoEndereco::ENTREGA));
        property_exists($request, 'Billing') ?? $enderecos->append(Endereco::fromRequest($request->Billing, TipoEndereco::COBRANCA));

        $cliente = new self(
            nome: $request->Name ?? null,
            status: property_exists($request, 'Status') ? Status::match($request->Status) : null,
            documento: Documento::fromRequest($request),
            email: $request->Email ?? null,
            nascimento: property_exists($request, 'Birthdate') ? new DateTime($request->Birthdate) : null,
            enderecos: $enderecos,
        );
        
        return $cliente;

    }

    public static function fromArray(array $data): self
    {
        $enderecos = new ArrayObject;

        if (array_key_exists('enderecos', $data)) {
            foreach ($data['enderecos'] as $tipo => $endereco) {
                if (in_array($tipo, TipoEndereco::enderecos())) {
                    $enderecos->append(Endereco::fromArray($endereco, TipoEndereco::match($tipo)));
                }
            }
        }

        $cliente = new self(
            nome: $data['nome'],
            status: array_key_exists('status', $data) ? Status::match($data['status']) : null,
            documento: Documento::fromArray($data['documento']),
            email: $data['email'] ?? null,
            nascimento: array_key_exists('nascimento', $data) ? new DateTime($data['nascimento']) : null,
            enderecos: $enderecos,
        );

        return $cliente;
    }

    public function toRequest(): array
    {
        $cliente = [
            'Name' => $this->nome,
            'Status' => !is_null($this->status) ? $this->status->value : null,
            'Identity' => $this->documento->numero,
            'IdentityType' => $this->documento->tipo->value,
            'Email' => $this->email,
            'Birthdate' => !is_null($this->nascimento) ? $this->nascimento->format('Y-m-d') : null,
        ];

        foreach ($this->enderecos as $endereco) {
            $tipo = $endereco->tipo->value;

            $cliente[$tipo] = $endereco->toRequest();
        }

        return array_filter($cliente, fn($value) => !is_null($value) && $value !== '');
    }
}
