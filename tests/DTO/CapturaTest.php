<?php

namespace MrPrompt\Cielo\Tests\DTO;

use MrPrompt\Cielo\DTO\Captura;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CapturaTest extends TestCase
{
    #[DataProvider('provideFromRequestData')]
    public function testFromRequestCreatesCapturaInstance(object $request, array $expected): void
    {
        $captura = Captura::fromRequest($request);

        $this->assertInstanceOf(Captura::class, $captura);
        $this->assertSame($expected['status'], $captura->status);
        $this->assertSame($expected['motivoCodigo'], $captura->motivoCodigo);
        $this->assertSame($expected['motivoMensagem'], $captura->motivoMensagem);
        $this->assertSame($expected['retornoCodigoProvedor'], $captura->retornoCodigoProvedor);
        $this->assertSame($expected['retornoMensagemProvedor'], $captura->retornoMensagemProvedor);
        $this->assertSame($expected['retornoCodigo'], $captura->retornoCodigo);
        $this->assertSame($expected['retornoMensagem'], $captura->retornoMensagem);
        $this->assertSame($expected['tid'], $captura->tid);
        $this->assertSame($expected['comprovante'], $captura->comprovante);
        $this->assertSame($expected['autorizacao'], $captura->autorizacao);
    }

    #[DataProvider('provideFromArrayData')]
    public function testFromArrayCreatesCapturaInstance(array $data, array $expected): void
    {
        $captura = Captura::fromArray($data);

        $this->assertInstanceOf(Captura::class, $captura);
        $this->assertSame($expected['status'], $captura->status);
        $this->assertSame($expected['motivoCodigo'], $captura->motivoCodigo);
        $this->assertSame($expected['motivoMensagem'], $captura->motivoMensagem);
        $this->assertSame($expected['retornoCodigoProvedor'], $captura->retornoCodigoProvedor);
        $this->assertSame($expected['retornoMensagemProvedor'], $captura->retornoMensagemProvedor);
        $this->assertSame($expected['retornoCodigo'], $captura->retornoCodigo);
        $this->assertSame($expected['retornoMensagem'], $captura->retornoMensagem);
        $this->assertSame($expected['tid'], $captura->tid);
        $this->assertSame($expected['comprovante'], $captura->comprovante);
        $this->assertSame($expected['autorizacao'], $captura->autorizacao);
    }

    public static function provideFromRequestData(): array
    {
        return [
            [
                (object) [
                    'Status' => 1,
                    'ReasonCode' => 100,
                    'ReasonMessage' => 'Success',
                    'ProviderReturnCode' => 200,
                    'ProviderReturnMessage' => 'Approved',
                    'ReturnCode' => 0,
                    'ReturnMessage' => 'OK',
                    'Tid' => '123456789',
                    'ProofOfSale' => '987654321',
                    'AuthorizationCode' => 'AUTH123',
                ],
                [
                    'status' => 1,
                    'motivoCodigo' => 100,
                    'motivoMensagem' => 'Success',
                    'retornoCodigoProvedor' => 200,
                    'retornoMensagemProvedor' => 'Approved',
                    'retornoCodigo' => 0,
                    'retornoMensagem' => 'OK',
                    'tid' => '123456789',
                    'comprovante' => '987654321',
                    'autorizacao' => 'AUTH123',
                ],
            ],
        ];
    }

    public static function provideFromArrayData(): array
    {
        return [
            [
                [
                    'status' => 1,
                    'motivoCodigo' => 100,
                    'motivoMensagem' => 'Success',
                    'retornoCodigoProvedor' => 200,
                    'retornoMensagemProvedor' => 'Approved',
                    'retornoCodigo' => 0,
                    'retornoMensagem' => 'OK',
                    'tid' => '123456789',
                    'comprovante' => '987654321',
                    'autorizacao' => 'AUTH123',
                ],
                [
                    'status' => 1,
                    'motivoCodigo' => 100,
                    'motivoMensagem' => 'Success',
                    'retornoCodigoProvedor' => 200,
                    'retornoMensagemProvedor' => 'Approved',
                    'retornoCodigo' => 0,
                    'retornoMensagem' => 'OK',
                    'tid' => '123456789',
                    'comprovante' => '987654321',
                    'autorizacao' => 'AUTH123',
                ],
            ],
        ];
    }
}