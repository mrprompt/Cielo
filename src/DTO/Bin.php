<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;

class Bin implements Dto
{
    public function __construct(
        public ?TipoCartao $tipo = null,
        public ?BandeiraCartao $bandeira = null,
        public ?string $numero = null,
        public ?string $status = null,
        public ?bool $estrangeiro = null,
        public ?bool $corporativo = null,
        public ?string $emissorNome = null,
        public ?string $emissorCodigo = null,
        public ?bool $prePago = null
    ) {}

    public static function fromRequest(object $request): self
    {
        return new self(
            tipo: TipoCartao::match($request->CardType ?? TipoCartao::CREDITO->value),
            bandeira: BandeiraCartao::match($request->Brand ?? $request->Provider ?? BandeiraCartao::MASTERCARD->value),
            numero: $request->CardNumber ?? null,
            status: $request->Status ?? null,
            estrangeiro: $request->ForeignCard ?? null,
            corporativo: $request->CorporateCard ?? null,
            emissorNome: $request->Issuer ?? null,
            emissorCodigo: $request->IssuerCode ?? null,
            prePago: $request->Prepaid ?? null
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tipo: TipoCartao::match($data['tipo'] ?? TipoCartao::CREDITO->value),
            bandeira: BandeiraCartao::match($data['bandeira'] ?? BandeiraCartao::MASTERCARD->value),
            numero: $data['numero'] ?? null,
            status: $data['status'] ?? null,
            estrangeiro: $data['estrangeiro'] ?? null,
            corporativo: $data['corporativo'] ?? null,
            emissorNome: $data['emissor'] ?? null,
            emissorCodigo: $data['banco'] ?? null,
            prePago: $data['prePago'] ?? null,
        );
    }

    public function toRequest(): array 
    {
        return ['CardNumber' => $this->numero];
    }
}
