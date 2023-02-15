<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\Adapters\ReflectionAdapter;
use Codememory\EntityResponseControl\ResponseControl;

interface ObjectDisassemblerInterface
{
    public function getIgnoredDataProperties(): array;

    public function setIgnoreDataProperties(array $names): self;

    public function addIgnoreDataProperty(string $name): self;

    public function getIgnoredAllDataPropertiesExpect(): array;

    public function setIgnoreAllDataPropertiesExcept(array $names): self;

    public function disassemble(object $object, ResponseControl $responseControl, ReflectionAdapter $reflectionAdapter): self;

    public function toArray(): array;
}