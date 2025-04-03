<?php

namespace MrPrompt\Cielo\Tests\DTO;


use MrPrompt\Cielo\DTO\Bin;
use MrPrompt\Cielo\Enum\Cartao\Bandeira as BandeiraCartao;
use MrPrompt\Cielo\Enum\Cartao\Tipo as TipoCartao;
use MrPrompt\Cielo\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;

class BinTest extends TestCase
{
    #[Test]
    #[DataProvider('fromRequestDataProvider')]
    public function testFromRequestCreatesBinInstance($request, $expected): void
    {
        $bin = Bin::fromRequest((object) $request);

        $this->assertInstanceOf(Bin::class, $bin);
        $this->assertEquals($expected['tipo'], $bin->tipo);
        $this->assertEquals($expected['bandeira'], $bin->bandeira);
        $this->assertEquals($expected['numero'], $bin->numero);
        $this->assertEquals($expected['status'], $bin->status);
        $this->assertEquals($expected['estrangeiro'], $bin->estrangeiro);
        $this->assertEquals($expected['corporativo'], $bin->corporativo);
        $this->assertEquals($expected['emissorNome'], $bin->emissorNome);
        $this->assertEquals($expected['emissorCodigo'], $bin->emissorCodigo);
        $this->assertEquals($expected['prePago'], $bin->prePago);
    }

    #[Test]
    #[DataProvider('fromArrayDataProvider')]
    public function testFromArrayCreatesBinInstance(array $data, array $expected): void
    {
        $bin = Bin::fromArray($data);

        $this->assertInstanceOf(Bin::class, $bin);
        $this->assertEquals($expected['tipo'], $bin->tipo);
        $this->assertEquals($expected['bandeira'], $bin->bandeira);
        $this->assertEquals($expected['numero'], $bin->numero);
        $this->assertEquals($expected['status'], $bin->status);
        $this->assertEquals($expected['estrangeiro'], $bin->estrangeiro);
        $this->assertEquals($expected['corporativo'], $bin->corporativo);
        $this->assertEquals($expected['emissorNome'], $bin->emissorNome);
        $this->assertEquals($expected['emissorCodigo'], $bin->emissorCodigo);
        $this->assertEquals($expected['prePago'], $bin->prePago);
    }

    public static function fromArrayDataProvider(): array
    {
        return [
            'valid array 1' => [
                'data' => [
                    'tipo' => TipoCartao::CREDITO->value,
                    'bandeira' => BandeiraCartao::VISA->value,
                    'numero' => '123456',
                    'status' => 'active',
                    'estrangeiro' => true,
                    'corporativo' => false,
                    'emissor' => 'Bank Name',
                    'banco' => '123',
                    'prePago' => true,
                ],
                'expected' => [
                    'tipo' => TipoCartao::CREDITO,
                    'bandeira' => BandeiraCartao::VISA,
                    'numero' => '123456',
                    'status' => 'active',
                    'estrangeiro' => true,
                    'corporativo' => false,
                    'emissorNome' => 'Bank Name',
                    'emissorCodigo' => '123',
                    'prePago' => true,
                ],
            ],
            'valid array 2' => [
                'data' => [
                    'tipo' => TipoCartao::DEBITO->value,
                    'bandeira' => BandeiraCartao::MASTERCARD->value,
                    'numero' => '654321',
                    'status' => 'inactive',
                    'estrangeiro' => false,
                    'corporativo' => true,
                    'emissor' => 'Another Bank',
                    'banco' => '456',
                    'prePago' => false,
                ],
                'expected' => [
                    'tipo' => TipoCartao::DEBITO,
                    'bandeira' => BandeiraCartao::MASTERCARD,
                    'numero' => '654321',
                    'status' => 'inactive',
                    'estrangeiro' => false,
                    'corporativo' => true,
                    'emissorNome' => 'Another Bank',
                    'emissorCodigo' => '456',
                    'prePago' => false,
                ],
            ],
        ];
    }

    public static function fromRequestDataProvider(): array
    {
        return [
            'valid request 1' => [
                'request' => [
                    'CardType' => TipoCartao::CREDITO->value,
                    'Brand' => BandeiraCartao::VISA->value,
                    'CardNumber' => '123456',
                    'Status' => 'active',
                    'ForeignCard' => true,
                    'CorporateCard' => false,
                    'Issuer' => 'Bank Name',
                    'IssuerCode' => '123',
                    'Prepaid' => true,
                ],
                'expected' => [
                    'tipo' => TipoCartao::CREDITO,
                    'bandeira' => BandeiraCartao::VISA,
                    'numero' => '123456',
                    'status' => 'active',
                    'estrangeiro' => true,
                    'corporativo' => false,
                    'emissorNome' => 'Bank Name',
                    'emissorCodigo' => '123',
                    'prePago' => true,
                ],
            ],
            'valid request 2' => [
                'request' => [
                    'CardType' => TipoCartao::DEBITO->value,
                    'Brand' => BandeiraCartao::MASTERCARD->value,
                    'CardNumber' => '654321',
                    'Status' => 'inactive',
                    'ForeignCard' => false,
                    'CorporateCard' => true,
                    'Issuer' => 'Another Bank',
                    'IssuerCode' => '456',
                    'Prepaid' => false,
                ],
                'expected' => [
                    'tipo' => TipoCartao::DEBITO,
                    'bandeira' => BandeiraCartao::MASTERCARD,
                    'numero' => '654321',
                    'status' => 'inactive',
                    'estrangeiro' => false,
                    'corporativo' => true,
                    'emissorNome' => 'Another Bank',
                    'emissorCodigo' => '456',
                    'prePago' => false,
                ],
            ],
        ];
    }
}
