<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\ResponseControl;
use Codememory\Reflection\Reflectors\ClassReflector;

interface ObjectDisassemblerInterface
{
    public function getIgnoredDataProperties(): array;

    public function setIgnoreDataProperties(array $names): self;

    public function addIgnoreDataProperty(string $name): self;

    public function getIgnoredAllDataPropertiesExpect(): array;

    public function setIgnoreAllDataPropertiesExcept(array $names): self;

    public function disassemble(object $object, ResponseControl $responseControl, ClassReflector $classReflector): self;

    public function toArray(): array;
}