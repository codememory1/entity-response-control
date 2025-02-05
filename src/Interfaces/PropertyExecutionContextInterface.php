<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface PropertyExecutionContextInterface
{
    public function setup(PropertyWrapperInterface $propertyWrapper, object $objectData): self;

    public function clear(): self;

    public function getPrototypeExecutionContext(): PrototypeExecutionContextInterface;

    public function getPropertyWrapper(): PropertyWrapperInterface;

    public function getObjectData(): object;

    public function getGetterNames(): array;

    public function setGetterNames(?array $names): self;

    public function isIgnore(): bool;

    public function setIgnore(bool $ignore): self;

    public function getValue(): mixed;

    public function setValue(mixed $value): self;

    public function getCollectedKey(): string;

    public function setCollectedKey(string $key): static;
}