<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use InvalidArgumentException;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Validacao\Cliente;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\DTO\Cliente as ClienteDto;

class ClienteTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid client')]
    public function testValidatePassesForValidCliente(): void
    {
        $cliente = ClienteDto::fromArray([
            'nome' => 'John Doe',
            'status' => 'NEW',
            'documento' => [
                'numero' => '12345678900',
                'tipo' => 'CPF'
            ],
            'email' => 'john.doe@example.com',
            'nascimento' => '1980-01-01',
            'endereco' => [
                'numero' => '123',
                'endereco' => 'Main St',
                'bairro' => 'Centro',
                'cidade' => 'Anytown',
                'estado' => 'SC',
                'cep' => '12345',
                'pais' => 'BRA',
            ],
            'entrega' => [
                'numero' => '456',
                'endereco' => 'Elm St',
                'bairro' => 'Centro',
                'cidade' => 'Othertown',
                'estado' => 'SC',
                'cep' => '67890',
                'pais' => 'BRA',
            ],
            'cobranca' => [
                'numero' => '789',
                'endereco' => 'Oak St',
                'bairro' => 'Centro',
                'cidade' => 'Sometown',
                'estado' => 'SC',
                'cep' => '11223',
                'pais' => 'BRA',
            ],
        ]);

        $result = Cliente::validate($cliente);

        $this->assertTrue($result);
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid client')]
    public function testValidateThrowsExceptionForInvalidCliente(): void
    {
        $this->expectException(ValidacaoErrors::class);
        // $this->expectExceptionMessage('Tipo de carteira inválida: invalid_type');

        $cliente = ClienteDto::fromArray([
            'nome' => 'John Doe',
            'status' => 'NEWz',
            'documento' => [
                'numero' => '12345678900',
                'tipo' => 'CPF'
            ],
            'email' => 'john.doe@example.com',
            'nascimento' => '1980-01-01',
            'endereco' => [
                'numero' => '123',
                'endereco' => 'Main St',
                'bairro' => 'Centro',
                'cidade' => 'Anytown',
                'estado' => 'SC',
                'cep' => '12345',
                'pais' => 'BRA',
            ],
            'entrega' => [
                'numero' => '456',
                'endereco' => 'Elm St',
                'bairro' => 'Centro',
                'cidade' => 'Othertown',
                'estado' => 'SC',
                'cep' => '67890',
                'pais' => 'BRA',
            ],
            'cobranca' => [
                'numero' => '789',
                'endereco' => 'Oak St',
                'bairro' => 'Centro',
                'cidade' => 'Sometown',
                'estado' => 'SC',
                'cep' => '11223',
                'pais' => 'BRA',
            ],
        ]);

        Cliente::validate($cliente);
    }
}
