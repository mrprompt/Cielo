<?php

namespace MrPrompt\Cielo\Contratos;

interface Dto
{
    public static function fromRequest(object $request): static;
    public static function fromArray(array $data): static;
    public function toRequest(): array;
}
