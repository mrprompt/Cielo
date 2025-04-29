<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;

class Cartao implements Dto
{
    public function __construct(
        public ?TipoCartao $tipo = null,
        public ?BandeiraCartao $bandeira = null,
        public ?string $nome = null,
        public ?string $numero = null,
        public ?string $validade = null,
        public ?string $codigoSeguranca = null,
        public ?string $portador = null,
        public ?string $token = null,
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
            nome: $request->CustomerName ?? null,
            numero: $request->CardNumber ?? null,
            validade: $request->ExpirationDate ?? null,
            codigoSeguranca: $request->SecurityCode ?? null,
            portador: $request->Holder ?? null,
            token: $request->CardToken ?? null,
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
            nome: $data['nome'] ?? null,
            numero: $data['numero'] ?? null,
            validade: $data['validade'] ?? null,
            codigoSeguranca: $data['codigoSeguranca'] ?? null,
            portador: $data['portador'] ?? null,
            token: $data['token'] ?? null,
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
        return array_filter([
            'CustomerName' => $this->nome,
            'CardType' => $this->tipo->value,
            'CardNumber' => $this->numero,
            'Holder' => $this->portador,
            'ExpirationDate' => $this->validade,
            'SecurityCode' => $this->codigoSeguranca,
            'Brand' => $this->bandeira->value,
            'CardToken' => $this->token,
            'ForeignCard' => $this->estrangeiro,
            'CorporateCard' => $this->corporativo,
            'Issuer' => $this->emissorNome,
            'IssuerCode' => $this->emissorCodigo,
            'Prepaid' => $this->prePago,
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
