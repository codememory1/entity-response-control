<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\AttributeReflector;
use Codememory\Reflection\Reflectors\PropertyReflector;

interface PropertyWrapperInterface
{
    public function getPropertyReflector(): PropertyReflector;

    public function getName(): string;

    public function setName(string $name): static;

    /**
     * @return array<int, AttributeReflector|object>
     */
    public function getAttributes(): array;

    /**
     * @param array<int, AttributeReflector|object> $attributes
     */
    public function setAttributes(array $attributes): static;

    public function prependAttribute(object $attribute): static;

    public function addAttribute(object ...$attribute): static;
}