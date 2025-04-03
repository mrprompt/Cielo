<?php

namespace MrPrompt\Cielo\Tests\Enum\Ambiente;

use PHPUnit\Framework\Attributes\Test;
use MrPrompt\Cielo\Enum\Ambiente\Sandbox;
use MrPrompt\Cielo\Tests\TestCase;

class SandboxTest extends TestCase
{
    #[Test]
    public function transacional()
    {
        $this->assertEquals('https://apisandbox.cieloecommerce.cielo.com.br/', Sandbox::TRANSACIONAL->value);
    }

    #[Test]
    public function consultas()
    {
        $this->assertEquals('https://apiquerysandbox.cieloecommerce.cielo.com.br/', Sandbox::CONSULTAS->value);
    }
}
