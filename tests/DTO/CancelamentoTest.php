<?php

namespace MrPrompt\Cielo\Tests\DTO;

use MrPrompt\Cielo\DTO\Cancelamento;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CancelamentoTest extends TestCase
{
    #[Test]
    #[DataProvider('fromRequestDataProvider')]
    public function testFromRequestCreatesCancelamentoInstance(object $request, array $expected): void
    {
        $cancelamento = Cancelamento::fromRequest($request);

        $this->assertInstanceOf(Cancelamento::class, $cancelamento);
        $this->assertEquals($expected['status'], $cancelamento->status);
        $this->assertEquals($expected['retornoCodigo'], $cancelamento->retornoCodigo);
        $this->assertEquals($expected['retornoMensagem'], $cancelamento->retornoMensagem);
        $this->assertEquals($expected['tid'], $cancelamento->tid);
        $this->assertEquals($expected['comprovante'], $cancelamento->comprovante);
        $this->assertEquals($expected['autorizacao'], $cancelamento->autorizacao);
    }

    #[Test]
    #[DataProvider('fromArrayDataProvider')]
    public function testFromArrayCreatesCancelamentoInstance(array $data, array $expected): void
    {
        $cancelamento = Cancelamento::fromArray($data);

        $this->assertInstanceOf(Cancelamento::class, $cancelamento);
        $this->assertEquals($expected['status'], $cancelamento->status);
        $this->assertEquals($expected['retornoCodigo'], $cancelamento->retornoCodigo);
        $this->assertEquals($expected['retornoMensagem'], $cancelamento->retornoMensagem);
        $this->assertEquals($expected['tid'], $cancelamento->tid);
        $this->assertEquals($expected['comprovante'], $cancelamento->comprovante);
        $this->assertEquals($expected['autorizacao'], $cancelamento->autorizacao);
    }

    public static function fromRequestDataProvider(): array
    {
        return [
            'valid request' => [
                (object) [
                    'Status' => 1,
                    'ReturnCode' => 200,
                    'ReturnMessage' => 'Success',
                    'Tid' => '123456789',
                    'ProofOfSale' => 'ABC123',
                    'AuthorizationCode' => 'AUTH456',
                ],
                [
                    'status' => 1,
                    'retornoCodigo' => 200,
                    'retornoMensagem' => 'Success',
                    'tid' => '123456789',
                    'comprovante' => 'ABC123',
                    'autorizacao' => 'AUTH456',
                ],
            ],
        ];
    }

    public static function fromArrayDataProvider(): array
    {
        return [
            'valid array' => [
                [
                    'status' => 1,
                    'retornoCodigo' => 200,
                    'retornoMensagem' => 'Success',
                    'tid' => '123456789',
                    'comprovante' => 'ABC123',
                    'autorizacao' => 'AUTH456',
                ],
                [
                    'status' => 1,
                    'retornoCodigo' => 200,
                    'retornoMensagem' => 'Success',
                    'tid' => '123456789',
                    'comprovante' => 'ABC123',
                    'autorizacao' => 'AUTH456',
                ],
            ],
        ];
    }
}