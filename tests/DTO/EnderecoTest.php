<?php

namespace MrPrompt\Cielo\Tests\DTO;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Endereco;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\Enum\Localizacao\Endereco as TipoEndereco;
use MrPrompt\Cielo\Enum\Localizacao\Estado;
use MrPrompt\Cielo\Enum\Localizacao\Pais;

class EnderecoTest extends TestCase
{
    #[Test]
    #[DataProvider('enderecoProvider')]
    #[TestDox('Testing Endereco fromRequest with street $requestData[Street]')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = (object) $requestData;

        $endereco = Endereco::fromRequest($request);

        $this->assertEquals($expectedData['endereco'], $endereco->endereco);
        $this->assertEquals($expectedData['numero'], $endereco->numero);
        $this->assertEquals($expectedData['complemento'], $endereco->complemento);
        $this->assertEquals($expectedData['cep'], $endereco->cep);
        $this->assertEquals($expectedData['cidade'], $endereco->cidade);
        $this->assertEquals($expectedData['estado'], $endereco->estado);
        $this->assertEquals($expectedData['pais'], $endereco->pais);
    }

    #[Test]
    #[DataProvider('enderecoProvider')]
    #[TestDox('Testing Endereco fromArray with street $requestData[endereco]')]
    public function testFromArray($requestData, $expectedData)
    {
        $modifiedData = $expectedData;
        $modifiedData['tipo'] = $expectedData['tipo']->value;
        $modifiedData['estado'] = $expectedData['estado']->value;
        $modifiedData['pais'] = $expectedData['pais']->value;

        $endereco = Endereco::fromArray($modifiedData);

        $this->assertEquals($expectedData['endereco'], $endereco->endereco);
        $this->assertEquals($expectedData['numero'], $endereco->numero);
        $this->assertEquals($expectedData['complemento'], $endereco->complemento);
        $this->assertEquals($expectedData['cep'], $endereco->cep);
        $this->assertEquals($expectedData['cidade'], $endereco->cidade);
        $this->assertEquals($expectedData['estado'], $endereco->estado);
        $this->assertEquals($expectedData['pais'], $endereco->pais);
    }

    public static function enderecoProvider(): array
    {
        return [
            [
                'requestData' => [
                    'Type' => TipoEndereco::PRINCIPAL->value,
                    'Street' => '123 Main St',
                    'Number' => '100',
                    'Complement' => 'Apt 1',
                    'ZipCode' => '12345',
                    'City' => 'Anytown',
                    'State' => Estado::SC->value,
                    'Country' => Pais::BRASIL->value,
                ],
                'expectedData' => [
                    'tipo' => TipoEndereco::PRINCIPAL,
                    'endereco' => '123 Main St',
                    'numero' => '100',
                    'complemento' => 'Apt 1',
                    'cep' => '12345',
                    'cidade' => 'Anytown',
                    'estado' => Estado::SC,
                    'pais' => Pais::BRASIL
                ]
            ],
            [
                'requestData' => [
                    'Type' => TipoEndereco::ENTREGA->value,
                    'Street' => '456 Elm St',
                    'Number' => '200',
                    'Complement' => null,
                    'ZipCode' => '67890',
                    'City' => 'Othertown',
                    'State' => Estado::SC->value,
                    'Country' => Pais::BRASIL->value,
                ],
                'expectedData' => [
                    'tipo' => TipoEndereco::ENTREGA,
                    'endereco' => '456 Elm St',
                    'numero' => '200',
                    'complemento' => null,
                    'cep' => '67890',
                    'cidade' => 'Othertown',
                    'estado' => Estado::SC,
                    'pais' => Pais::BRASIL
                ]
            ],
        ];
    }
}
