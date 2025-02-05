<?php

namespace Codememory\EntityResponseControl\Wrappers;

use Codememory\EntityResponseControl\Interfaces\PropertyWrapperInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;

class PropertyWrapper implements PropertyWrapperInterface
{
    private string $name;
    private array $attributes;

    public function __construct(
        private readonly PropertyReflector $propertyReflector
    ) {
        $this->name = $this->propertyReflector->getName();
        $this->attributes = $this->propertyReflector->getAttributes();
    }

    public function getPropertyReflector(): PropertyReflector
    {
        return $this->propertyReflector;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function prependAttribute(object $attribute): static
    {
        array_unshift($this->attributes, $attribute);

        return $this;
    }

    public function addAttribute(object ...$attribute): static
    {
        $this->attributes += $attribute;

        return $this;
    }
}