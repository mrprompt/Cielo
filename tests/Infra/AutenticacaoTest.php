<?php

namespace MrPrompt\Cielo\Tests\Infra;

use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Infra\Autenticacao;
use MrPrompt\Cielo\Tests\TestCase;

class AutenticacaoTest extends TestCase
{
    #[Test]
    public function construtor()
    {
        $merchantId = 'test-merchant-id';
        $merchantKey = 'test-merchant-key';

        $autenticacao = new Autenticacao($merchantId, $merchantKey);

        $this->assertEquals($merchantId, $autenticacao->merchantId);
        $this->assertEquals($merchantKey, $autenticacao->merchantKey);
    }
}
