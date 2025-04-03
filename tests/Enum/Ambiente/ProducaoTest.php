<?php

namespace MrPrompt\Cielo\Tests\Enum\Ambiente;

use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Enum\Ambiente\Producao;
use MrPrompt\Cielo\Tests\TestCase;

class ProducaoTest extends TestCase
{
    #[Test]
    public function transacional()
    {
        $this->assertEquals('https://api.cieloecommerce.cielo.com.br/', Producao::TRANSACIONAL->value);
    }

    #[Test]
    public function consultas()
    {
        $this->assertEquals('https://apiquery.cieloecommerce.cielo.com.br/', Producao::CONSULTAS->value);
    }
}
