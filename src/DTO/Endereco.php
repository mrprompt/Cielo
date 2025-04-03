<?php

namespace MrPrompt\Cielo\DTO;

use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Cliente\Endereco as TipoEndereco;
use MrPrompt\Cielo\Enum\Cliente\Estado;
use MrPrompt\Cielo\Enum\Cliente\Pais;

class Endereco implements Dto
{
    public function __construct(
        public TipoEndereco $tipo,
        public string $endereco,
        public string $numero,
        public string $complemento,
        public string $cep,
        public string $cidade,
        public Estado $estado,
        public Pais $pais
    ) {}

    public static function fromRequest(object $request, TipoEndereco $tipo = TipoEndereco::RESIDENCIAL): self
    {
        return new self(
            tipo: $tipo,
            endereco: $request->Street,
            numero: $request->Number ?? '',
            complemento: $request->Complement ?? '',
            cep: $request->ZipCode,
            cidade: $request->City,
            estado: Estado::match($request->State),
            pais: Pais::match($request->Country)
        );
    }

    public static function fromArray(array $data, TipoEndereco $tipo = TipoEndereco::RESIDENCIAL): self
    {
        return new self(
            tipo: $tipo,
            endereco: $data['endereco'],
            numero: $data['numero'] ?? '',
            complemento: $data['complemento'] ?? '',
            cep: $data['cep'],
            cidade: $data['cidade'],
            estado: Estado::match($data['estado']),
            pais: Pais::match($data['pais'])
        );
    }

    public function toRequest(): array
    {
        return array_filter([
            'Street' => $this->endereco,
            'Number' => $this->numero,
            'Complement' => $this->complemento,
            'ZipCode' => $this->cep,
            'City' => $this->cidade,
            'State' => $this->estado->value,
            'Country' => $this->pais->value,
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
