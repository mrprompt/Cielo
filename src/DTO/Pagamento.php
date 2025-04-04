<?php

namespace MrPrompt\Cielo\DTO;

use DateTime;
use MrPrompt\Cielo\Contratos\Dto;
use MrPrompt\Cielo\Enum\Pagamento\Moeda;
use MrPrompt\Cielo\Enum\Pagamento\Parcelamento;
use MrPrompt\Cielo\Enum\Pagamento\Provedor;
use MrPrompt\Cielo\Enum\Pagamento\Tipo;
use MrPrompt\Cielo\Enum\Localizacao\Pais;

class Pagamento implements Dto
{
    public function __construct(
        public ?string $id = null,
        public ?Tipo $tipo = null,
        public ?int $valor = null,
        public ?Moeda $moeda = null,
        public ?Provedor $provedor = null,
        public ?int $taxas = null,
        public ?string $descricao = null,
        public ?int $parcelas = null,
        public ?Parcelamento $parcelas_tipo = null,
        public ?bool $captura = null,
        public ?bool $autenticacao = null,
        public ?bool $recorrente = null,
        public ?bool $criptomoeda = null,
        public ?Cartao $cartao = null,
        public ?string $identificador = null,
        public ?bool $qrcode = null,
        public ?DateTime $recebimento = null,
        public ?int $status = null,
        public ?bool $dividida = null,
        public ?Pais $pais = null,
        public ?int $codigoRetorno = null,
        public ?string $mensagemRetorno = null,
    ) {}

    public static function fromRequest(object $request): self
    {
        $object = new self(
            id: $request->PaymentId ?? null,
            tipo: Tipo::match($request->Type),
            valor: $request->Amount ?? null,
            moeda: Moeda::match($request->Currency),
            provedor: Provedor::match($request->Provider),
            taxas: $request->ServiceTaxAmount ?? null,
            descricao: $request->SoftDescriptor ?? null,
            parcelas: $request->Installments ?? null,
            parcelas_tipo: property_exists($request, 'Interest') ? Parcelamento::match($request->Interest) : null,
            captura: $request->Capture ?? null,
            autenticacao: $request->Authenticate ?? null,
            recorrente: $request->Recurrent ?? null,
            criptomoeda: $request->IsCryptocurrencyNegociation ?? null,
            identificador: $request->Tid ?? null,
            qrcode: $request->IsQrCode ?? null,
            recebimento: property_exists($request, 'ReceivedDate') ? new DateTime($request->ReceivedDate) : null,
            status: $request->Status ?? null,
            dividida: $request->IsSplitted ?? null,
            pais: property_exists($request, 'Country') ? Pais::match($request->Country) : null,
            codigoRetorno: $request->ReturnCode ?? null,
            mensagemRetorno: $request->ReturnMessage ?? null,
        );

        if (property_exists($request, 'CreditCard')) {
            $object->cartao = Cartao::fromRequest($request->CreditCard);
        }

        if (property_exists($request, 'DebitCard')) {
            $object->cartao = Cartao::fromRequest($request->DebitCard);
        }

        return $object;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            tipo: array_key_exists('tipo', $data) ? Tipo::match($data['tipo']) : null,
            valor: $data['valor'] ?? null,
            moeda: array_key_exists('moeda', $data) ? Moeda::match($data['moeda']) : null,
            provedor: array_key_exists('provedor', $data) ? Provedor::match($data['provedor']) : null,
            taxas: $data['taxas'] ?? null,
            descricao: $data['descricao'] ?? null,
            parcelas: $data['parcelas'] ?? null,
            parcelas_tipo: array_key_exists('parcelas_tipo', $data) ? Parcelamento::match($data['parcelas_tipo']) : null,
            captura: $data['captura'] ?? null,
            autenticacao: $data['autenticacao'] ?? null,
            recorrente: $data['recorrente'] ?? null,
            criptomoeda: $data['criptomoeda'] ?? null,
            cartao: array_key_exists('cartao', $data) ? Cartao::fromArray($data['cartao']) : null,
            identificador: $data['identificador'] ?? null,
            qrcode: $data['qrcode'] ?? null,
            recebimento: array_key_exists('recebimento', $data) ? new DateTime($data['recebimento']) : null,
            status: $data['status'] ?? null,
            dividida: $data['dividida'] ?? null,
            pais: array_key_exists('pais', $data) ? Pais::match($data['pais']) : null,
            codigoRetorno: array_key_exists('codigoRetorno', $data) ? $data['codigoRetorno'] : null,
            mensagemRetorno: array_key_exists('mensagemRetorno', $data) ? $data['mensagemRetorno'] : null,
        );
    }

    public function toRequest(): array
    {
        $request = [
            'Type' => !is_null($this->tipo) ? $this->tipo->value : null,
            'Amount' => $this->valor,
            'Currency' => !is_null($this->moeda) ? $this->moeda->value : null,
            'Provider' => !is_null($this->provedor) ? $this->provedor->value : null,
            'ServiceTaxAmount' => $this->taxas,
            'SoftDescriptor' => $this->descricao,
            'Installments' => $this->parcelas,
            'Interest' => !is_null($this->parcelas_tipo) ? $this->parcelas_tipo->value : null,
            'Capture' => $this->captura ?? null,
            'Authenticate' => $this->autenticacao ?? null,
            'Recurrent' => $this->recorrente ?? null,
        ];

        if (!is_null($this->cartao)) {
            $request[ $this->cartao->tipo->value ] = $this->cartao->toRequest();
        }

        return array_filter($request, fn($value) => !is_null($value) && $value !== '');
    }
}
