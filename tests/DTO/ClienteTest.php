<?php

namespace MrPrompt\Cielo\Tests\DTO;

use DateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\DTO\Cliente;
use MrPrompt\Cielo\DTO\Documento;
use MrPrompt\Cielo\Enum\Cliente\Status;
use MrPrompt\Cielo\DTO\Endereco;
use MrPrompt\Cielo\Enum\Cliente\Endereco as TipoEndereco;
use MrPrompt\Cielo\Enum\Cliente\Estado;
use MrPrompt\Cielo\Enum\Cliente\Pais;
use MrPrompt\Cielo\Tests\TestCase;

class ClienteTest extends TestCase
{
    #[Test]
    #[DataProvider('clienteRequestProvider')]
    #[TestDox('Testing Cliente fromRequest ')]
    public function testFromRequest($requestData, $expectedData)
    {
        $request = json_decode(json_encode($requestData));
        $cliente = Cliente::fromRequest($request);

        $this->assertInstanceOf(Cliente::class, $cliente);
        $this->assertEquals($expectedData['nome'], $cliente->nome);
        $this->assertEquals($expectedData['status'], $cliente->status);
        $this->assertEquals($expectedData['documento'], $cliente->documento);
        $this->assertEquals($expectedData['email'], $cliente->email);
        $this->assertEquals($expectedData['nascimento'], $cliente->nascimento);
        $this->assertEquals($expectedData['endereco'], $cliente->endereco);
        $this->assertEquals($expectedData['entrega'], $cliente->entrega);
        $this->assertEquals($expectedData['cobranca'], $cliente->cobranca);
    }

    #[Test]
    #[DataProvider('clienteArrayProvider')]
    #[TestDox('Testing Cliente fromArray')]
    public function testFromArray($requestData)
    {
        $cliente = Cliente::fromArray($requestData);

        $this->assertInstanceOf(Cliente::class, $cliente);
        $this->assertInstanceOf(Status::class, $cliente->status);
        $this->assertInstanceOf(Documento::class, $cliente->documento);
        $this->assertInstanceOf(Endereco::class, $cliente->endereco);
        $this->assertInstanceOf(Endereco::class, $cliente->entrega);
        $this->assertInstanceOf(Endereco::class, $cliente->cobranca);
    }

    public static function clienteRequestProvider(): array
    {
        return [
            [
                'requestData' => [
                    'Name' => 'John Doe',
                    'Status' => 'NEW',
                    'Identity' => '12345678900',
                    'IdentityType' => 'CPF',
                    'Email' => 'john.doe@example.com',
                    'Birthdate' => '1980-01-01',
                    'Address' => [
                        'Street' => '123 Main St',
                        'City' => 'Anytown',
                        'State' => Estado::SC->value,
                        'ZipCode' => '12345',
                        'Country' => Pais::BRASIL->value,
                    ],
                    'DeliveryAddress' => [
                        'Street' => '456 Elm St',
                        'City' => 'Othertown',
                        'State' => Estado::SC->value,
                        'ZipCode' => '67890',
                        'Country' => Pais::BRASIL->value,
                    ],
                    'Billing' => [
                        'Street' => '789 Oak St',
                        'City' => 'Sometown',
                        'State' => Estado::SC->value,
                        'ZipCode' => '11223',
                        'Country' => Pais::BRASIL->value,
                    ]
                ],
                'expectedData' => [
                    'nome' => 'John Doe',
                    'status' => Status::match('NEW'),
                    'documento' => Documento::fromArray([
                        'numero' => '12345678900',
                        'tipo' => 'CPF'
                    ]),
                    'email' => 'john.doe@example.com',
                    'nascimento' => new DateTime('1980-01-01'),
                    'endereco' => Endereco::fromArray([
                        'endereco' => '123 Main St',
                        'cidade' => 'Anytown',
                        'estado' => Estado::SC->value,
                        'cep' => '12345',
                        'pais' => Pais::BRASIL->value,
                    ], TipoEndereco::RESIDENCIAL),
                    'entrega' => Endereco::fromArray([
                        'endereco' => '456 Elm St',
                        'cidade' => 'Othertown',
                        'estado' => Estado::SC->value,
                        'cep' => '67890',
                        'pais' => Pais::BRASIL->value,
                    ], TipoEndereco::ENTREGA),
                    'cobranca' => Endereco::fromArray([
                        'endereco' => '789 Oak St',
                        'cidade' => 'Sometown',
                        'estado' => Estado::SC->value,
                        'cep' => '11223',
                        'pais' => Pais::BRASIL->value,
                    ], TipoEndereco::COBRANCA)
                ]
            ],
            [
                'requestData' => [
                    'Name' => 'John Doe',
                    'Status' => 'EXISTING',
                    'Identity' => '12345678900',
                    'IdentityType' => 'CNPJ',
                    'Email' => 'john.doe@example.com',
                    'Birthdate' => '1980-01-01',
                    'Address' => [
                        'Street' => '123 Main St',
                        'City' => 'Anytown',
                        'State' => Estado::SC->value,
                        'ZipCode' => '12345',
                        'Country' => Pais::BRASIL->value,
                    ],
                    'DeliveryAddress' => [
                        'Street' => '456 Elm St',
                        'City' => 'Othertown',
                        'State' => Estado::SC->value,
                        'ZipCode' => '67890',
                        'Country' => Pais::BRASIL->value,
                    ],
                    'Billing' => [
                        'Street' => '789 Oak St',
                        'City' => 'Sometown',
                        'State' => Estado::SC->value,
                        'ZipCode' => '11223',
                        'Country' => Pais::BRASIL->value,
                    ]
                ],
                'expectedData' => [
                    'nome' =>  'John Doe',
                    'status' =>  Status::match('EXISTING'),
                    'documento' => Documento::fromArray([
                        'numero' => '12345678900',
                        'tipo' => 'CNPJ'
                    ]),
                    'email' =>  'john.doe@example.com',
                    'nascimento' =>  new DateTime('1980-01-01'),
                    'endereco' => Endereco::fromArray([
                        'endereco' =>  '123 Main St',
                        'cidade' =>  'Anytown',
                        'estado' =>  Estado::SC->value,
                        'cep' =>  '12345',
                        'pais' =>  Pais::BRASIL->value,
                    ], TipoEndereco::RESIDENCIAL),
                    'entrega' => Endereco::fromArray([
                        'endereco' => '456 Elm St',
                        'cidade' => 'Othertown',
                        'estado' => Estado::SC->value,
                        'cep' => '67890',
                        'pais' => Pais::BRASIL->value,
                    ], TipoEndereco::ENTREGA),
                    'cobranca' => Endereco::fromArray([
                        'endereco' => '789 Oak St',
                        'cidade' => 'Sometown',
                        'estado' => Estado::SC->value,
                        'cep' => '11223',
                        'pais' => Pais::BRASIL->value,
                    ], TipoEndereco::COBRANCA)
                ]
            ],
        ];
    }

    public static function clienteArrayProvider(): array
    {
        return [
            [
                [
                    'nome' => 'John Doe New',
                    'status' => 'NEW',
                    'documento' => [
                        'numero' => '12345678900',
                        'tipo' => 'CPF'
                    ],
                    'email' => 'john.doe.new@example.com',
                    'nascimento' => '1980-01-01',
                    'endereco' => [
                        'endereco' => '123 Main St',
                        'cidade' => 'Anytown',
                        'estado' => Estado::SC->value,
                        'cep' => '12345',
                        'pais' => Pais::BRASIL->value,
                    ],
                    'entrega' => [
                        'endereco' => '456 Elm St',
                        'cidade' => 'Othertown',
                        'estado' => Estado::SC->value,
                        'cep' => '67890',
                        'pais' => Pais::BRASIL->value,
                    ],
                    'cobranca' => [
                        'endereco' => '789 Oak St',
                        'cidade' => 'Sometown',
                        'estado' => Estado::SC->value,
                        'cep' => '11223',
                        'pais' => Pais::BRASIL->value,
                    ],
                ]
            ],
            [
                [
                    'nome' =>  'John Doe Existing',
                    'status' => 'EXISTING',
                    'documento' => [
                        'numero' => '12345678900',
                        'tipo' => 'CNPJ'
                    ],
                    'email' =>  'john.doe.existing@example.com',
                    'nascimento' =>  '1980-01-01',
                    'endereco' => [
                        'endereco' =>  '123 Main St',
                        'cidade' =>  'Anytown',
                        'estado' =>  Estado::SC->value,
                        'cep' =>  '12345',
                        'pais' =>  Pais::BRASIL->value,
                    ],
                    'entrega' => [
                        'endereco' => '456 Elm St',
                        'cidade' => 'Othertown',
                        'estado' => Estado::SC->value,
                        'cep' => '67890',
                        'pais' => Pais::BRASIL->value,
                    ],
                    'cobranca' => [
                        'endereco' => '789 Oak St',
                        'cidade' => 'Sometown',
                        'estado' => Estado::SC->value,
                        'cep' => '11223',
                        'pais' => Pais::BRASIL->value,
                    ],
                ]
            ],
        ];
    }
}
