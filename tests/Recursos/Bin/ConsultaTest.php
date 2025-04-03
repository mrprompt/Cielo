<?php

namespace MrPrompt\Cielo\Tests\Recursos\Bin;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use MrPrompt\Cielo\Tests\TestCase;
use MrPrompt\Cielo\Recursos\Bin\Consulta;
use MrPrompt\Cielo\DTO\Bin as BinDto;
use MrPrompt\Cielo\Infra\Ambiente;
use MrPrompt\Cielo\Infra\Autenticacao;
use MrPrompt\Cielo\Infra\HttpDriver;

class ConsultaTest extends TestCase
{
    #[Test]
    #[DataProvider('validBinProvider')]
    #[TestDox('Testing bin using card $bin expects success')]
    public function invokeWithValidParams($bin, $binResponse)
    {
        // Cria mocks para as dependências
        $mockClient = $this->createMock(Client::class);
        $mockAmbiente = $this->createMock(Ambiente::class);
        $mockAutenticacao = $this->createMock(Autenticacao::class, ['merchantId', 'merchantKey']);
        $mockDriver = $this->createMock(HttpDriver::class, [$mockAmbiente, $mockClient, $mockAutenticacao]);
        $mockDriver->expects($this->once())
                   ->method('get')
                   ->with($this->equalTo('1/cardBin/' . $bin))
                   ->willReturn(new Response(200, [], json_encode($binResponse)));

        $consulta = new Consulta($mockDriver);
        $result = $consulta->__invoke(BinDto::fromArray(['numero' => $bin]));

        $this->assertEquals(BinDto::fromRequest((object) $binResponse), $result);
    }

    #[Test]
    #[DataProvider('invalidBinProvider')]
    #[TestDox('Testing bin using card $bin expects failure')]
    public function invokeWithInvalidParams($bin, $binResponse)
    {
        // Cria mocks para as dependências
        $mockClient = $this->createMock(Client::class);
        $mockAmbiente = $this->createMock(Ambiente::class);
        $mockAutenticacao = $this->createMock(Autenticacao::class, ['merchantId', 'merchantKey']);
        $mockDriver = $this->createMock(HttpDriver::class, [$mockAmbiente, $mockClient, $mockAutenticacao]);
        $mockDriver->expects($this->once())
                   ->method('get')
                   ->with($this->equalTo('1/cardBin/' . $bin))
                   ->willReturn(new Response(200, [], json_encode($binResponse)));

        $consulta = new Consulta($mockDriver);
        $result = $consulta->__invoke(BinDto::fromArray(['numero' => $bin]));

        $this->assertEquals(BinDto::fromRequest((object) $binResponse), $result);
    }

    public static function validBinProvider()
    {
        return [
            [
                '4510110012341234',
                [
                    "Status" => "00",
                    "Provider" => "VISA",
                    "CardType" => "Crédito",
                    "ForeignCard" => false,
                    "CorporateCard" => false,
                    "Issuer" => "Caixa",
                    "IssuerCode" => "104",
                    "Prepaid" => false
                ]
            ],
        ];
    }

    public static function invalidBinProvider()
    {
        return [
            [
                '4512210012341234',
                [
                    "Code" => 1,
                    "Message" => "Bandeira não suportada"
                ],
            ],
        ];
    }
}
