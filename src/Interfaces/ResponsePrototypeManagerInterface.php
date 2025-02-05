<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ResponsePrototypeManagerInterface
{
    public function collect(string $prototypeClassName, array|object $data, array $decorators = [], array $metadata = []): array;
}