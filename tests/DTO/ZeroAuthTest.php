<?php

namespace MrPrompt\Cielo\Tests\DTO;

use MrPrompt\Cielo\DTO\ZeroAuth;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class ZeroAuthTest extends TestCase
{
    #[Test]
    #[DataProvider('fromRequestDataProvider')]
    public function testFromRequestCreatesInstanceCorrectly(object $request, bool $expectedValid, string $expectedCode, string $expectedMessage, string $expectedIdentifier): void
    {
        $zeroAuth = ZeroAuth::fromRequest($request);

        $this->assertInstanceOf(ZeroAuth::class, $zeroAuth);
        $this->assertSame($expectedValid, $zeroAuth->valido);
        $this->assertSame($expectedCode, $zeroAuth->codigo);
        $this->assertSame($expectedMessage, $zeroAuth->mensagem);
        $this->assertSame($expectedIdentifier, $zeroAuth->identificador);
    }

    public static function fromRequestDataProvider(): array
    {
        return [
            [
                (object) [
                    'Valid' => true,
                    'ReturnCode' => '00',
                    'ReturnMessage' => 'Success',
                    'IssuerTransactionId' => '123456'
                ],
                true,
                '00',
                'Success',
                '123456'
            ],
        ];
    }

    #[Test]
    #[DataProvider('fromArrayDataProvider')]
    public function testFromArrayCreatesInstanceCorrectly(array $data, bool $expectedValid, string $expectedCode, string $expectedMessage, string $expectedIdentifier): void
    {
        $zeroAuth = ZeroAuth::fromArray($data);

        $this->assertInstanceOf(ZeroAuth::class, $zeroAuth);
        $this->assertSame($expectedValid, $zeroAuth->valido);
        $this->assertSame($expectedCode, $zeroAuth->codigo);
        $this->assertSame($expectedMessage, $zeroAuth->mensagem);
        $this->assertSame($expectedIdentifier, $zeroAuth->identificador);
    }

    public static function fromArrayDataProvider(): array
    {
        return [
            [
                [
                    'valido' => true,
                    'codigo' => '00',
                    'mensagem' => 'Success',
                    'identificador' => '123456'
                ],
                true,
                '00',
                'Success',
                '123456'
            ],
        ];
    }

    #[Test]
    public function testToRequestReturnsEmptyArray(): void
    {
        $zeroAuth = new ZeroAuth();

        $this->assertSame([], $zeroAuth->toRequest());
    }

    #[Test]
    #[DataProvider('gettersDataProvider')]
    public function testGettersReturnCorrectValues(bool $valid, string $code, string $message, string $identifier): void
    {
        $zeroAuth = new ZeroAuth(
            valido: $valid,
            codigo: $code,
            mensagem: $message,
            identificador: $identifier
        );

        $this->assertSame($valid, $zeroAuth->valido);
        $this->assertSame($code, $zeroAuth->codigo);
        $this->assertSame($message, $zeroAuth->mensagem);
        $this->assertSame($identifier, $zeroAuth->identificador);
    }

    public static function gettersDataProvider(): array
    {
        return [
            [true, '00', 'Success', '123456'],
        ];
    }
}
