<?php

namespace MrPrompt\Cielo\Contratos;

interface Dto
{
    public static function fromRequest(object $request): self;
    public static function fromArray(array $data): self;
    
    public function toRequest(): array;
}
