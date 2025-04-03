<?php

namespace MrPrompt\Cielo\Tests\Validacao;

use InvalidArgumentException;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Validacao\Endereco;
use MrPrompt\Cielo\Exceptions\ValidacaoErrors;
use MrPrompt\Cielo\DTO\Endereco as EnderecoDto;

class EnderecoTest extends TestCase
{
    #[Test]
    #[TestDox('Ensure validate method passes for valid client')]
    public function testValidatePassesForValidCliente(): void
    {
        $cliente = EnderecoDto::fromArray([
            'endereco' => 'Elm St',
            'numero' => '456',
            'cidade' => 'Othertown',
            'estado' => 'SC',
            'cep' => '67890',
            'pais' => 'BRA',
        ]);

        $result = Endereco::validate($cliente);

        $this->assertTrue($result);
    }

    #[Test]
    #[TestDox('Ensure validate method throws exception for invalid client')]
    public function testValidateThrowsExceptionForInvalidCliente(): void
    {
        $this->expectException(InvalidArgumentException::class);
        // $this->expectExceptionMessage('Tipo de carteira inválida: invalid_type');

        $cliente = EnderecoDto::fromArray([
            'endereco' => '',
            'numero' => '',
            'cidade' => '',
            'estado' => '',
            'cep' => '',
            'pais' => '',
        ]);

        Endereco::validate($cliente);
    }
}
