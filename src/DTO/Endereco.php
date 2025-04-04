<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as TipoEndereco;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;

class Endereco implements Dto
{
    public function __construct(
        public TipoEndereco $tipo,
        public string $endereco,
        public ?string $numero,
        public ?string $complemento,
        public string $bairro,
        public string $cep,
        public string $cidade,
        public Estado $estado,
        public Pais $pais
    ) {}

    public static function fromRequest(object $request, TipoEndereco $tipo = TipoEndereco::RESIDENCIAL): self
    {
        return new self(
            tipo: $tipo,
            endereco: $request->Street ?? null,
            numero: $request->Number ?? null,
            complemento: $request->Complement ?? null,
            bairro: $request->District ?? null,
            cep: $request->ZipCode ?? null,
            cidade: $request->City ?? null,
            estado: property_exists($request, 'State') ? Estado::match($request->State) : null,
            pais: property_exists($request, 'Country') ? Pais::match($request->Country) : null
        );
    }

    public static function fromArray(array $data, TipoEndereco $tipo = TipoEndereco::RESIDENCIAL): self
    {
        return new self(
            tipo: $tipo,
            endereco: $data['endereco'],
            numero: $data['numero'] ?? null,
            complemento: $data['complemento'] ?? null,
            bairro: $data['bairro'] ?? null,
            cep: $data['cep'] ?? null,
            cidade: $data['cidade'] ?? null,
            estado: array_key_exists('estado', $data) ? Estado::match($data['estado']) : null,
            pais: array_key_exists('pais', $data) ? Pais::match($data['pais']) : null
        );
    }

    public function toRequest(): array
    {
        return array_filter([
            'Street' => $this->endereco,
            'Number' => $this->numero,
            'Complement' => $this->complemento,
            'District'=> $this->bairro,
            'ZipCode' => $this->cep,
            'City' => $this->cidade,
            'State' => $this->estado->value,
            'Country' => $this->pais->value,
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
