<?php

namespace MrPrompt\Cielo\Contratos;

interface Ambiente
{
    public function transacional(): string;
    public function consultas(): string;
}
