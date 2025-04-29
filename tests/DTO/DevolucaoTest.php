<?php

namespace MrPrompt\Cielo\Tests\DTO;

use MrPrompt\Cielo\DTO\Devolucao;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DevolucaoTest extends TestCase
{
    #[DataProvider('provideFromRequestData')]
    public function testFromRequestCreatesDevolucaoInstance(object $request, array $expected): void
    {
        $devolucao = Devolucao::fromRequest($request);

        $this->assertInstanceOf(Devolucao::class, $devolucao);
        $this->assertSame($expected['status'], $devolucao->status);
        $this->assertSame($expected['motivoCodigo'], $devolucao->motivoCodigo);
        $this->assertSame($expected['motivoMensagem'], $devolucao->motivoMensagem);
        $this->assertSame($expected['retornoCodigo'], $devolucao->retornoCodigo);
        $this->assertSame($expected['retornoMensagem'], $devolucao->retornoMensagem);
    }

    #[DataProvider('provideFromArrayData')]
    public function testFromArrayCreatesDevolucaoInstance(array $data, array $expected): void
    {
        $devolucao = Devolucao::fromArray($data);

        $this->assertInstanceOf(Devolucao::class, $devolucao);
        $this->assertSame($expected['status'], $devolucao->status);
        $this->assertSame($expected['motivoCodigo'], $devolucao->motivoCodigo);
        $this->assertSame($expected['motivoMensagem'], $devolucao->motivoMensagem);
        $this->assertSame($expected['retornoCodigo'], $devolucao->retornoCodigo);
        $this->assertSame($expected['retornoMensagem'], $devolucao->retornoMensagem);
    }

    public static function provideFromRequestData(): array
    {
        return [
            [
                (object) [
                    'Status' => 1,
                    'ReasonCode' => '100',
                    'ReasonMessage' => 'Success',
                    'ReturnCode' => '0',
                    'ReturnMessage' => 'OK',
                ],
                [
                    'status' => 1,
                    'motivoCodigo' => '100',
                    'motivoMensagem' => 'Success',
                    'retornoCodigo' => '0',
                    'retornoMensagem' => 'OK',
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
                    'motivoCodigo' => '100',
                    'motivoMensagem' => 'Success',
                    'retornoCodigo' => '0',
                    'retornoMensagem' => 'OK',
                ],
                [
                    'status' => 1,
                    'motivoCodigo' => '100',
                    'motivoMensagem' => 'Success',
                    'retornoCodigo' => '0',
                    'retornoMensagem' => 'OK',
                ],
            ],
        ];
    }
}