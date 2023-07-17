<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\PropertyReflector;

interface ExecutionContextInterface
{
    public function getResponsePrototype(): ResponsePrototypeInterface;

    public function getProperty(): PropertyReflector;

    public function getResponseKey(): string;

    public function setResponseKey(string $name): self;

    public function getNameGetterToGetValueFromObject(): string;

    public function setNameGetterToGetValueFromObject(string $name): self;

    public function getValue(): mixed;

    public function setValue(mixed $value): self;

    public function getPrototypeObject(): object;

    public function isSkippedThisProperty(): bool;

    public function setSkipThisProperty(bool $skip): self;
}