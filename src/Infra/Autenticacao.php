<?php

namespace MrPrompt\Cielo\Infra;

class Autenticacao
{
    public function __construct(public readonly string $merchantId, public readonly string $merchantKey) {}
}
