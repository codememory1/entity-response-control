<?php

namespace Codememory\EntityResponseControl;

use Codememory\Reflection\Reflectors\PropertyReflector;
use function Symfony\Component\String\u;

final class ConstraintTypeControl
{
    private string $propertyNameInResponse;
    private string $prefixMethod;
    private bool $isAllowedToOutput = true;
    private mixed $value;

    public function __construct(
        public readonly ResponseControl $responseControl,
        public readonly PropertyReflector $property,
        public readonly object $object
    ) {
        $this->propertyNameInResponse = u($this->property->getName())->snake()->toString();
        $this->prefixMethod = 'get';

        if (method_exists($this->object, $this->getMethodName())) {
            $this->value = $this->object->{$this->getMethodName()}();
        } else {
            $this->value = $this->property->getDefaultValue();
        }
    }

    public function getPropertyNameInResponse(): string
    {
        return $this->propertyNameInResponse;
    }

    public function setPropertyNameInResponse(string $name): self
    {
        $this->propertyNameInResponse = $name;

        return $this;
    }

    public function getMethodName(): string
    {
        return u("{$this->prefixMethod}_{$this->property->getName()}")
            ->camel()
            ->toString();
    }

    public function setPrefixMethod(string $prefix): self
    {
        $this->prefixMethod = $prefix;

        return $this;
    }

    public function isAllowedToOutput(): bool
    {
        return $this->isAllowedToOutput;
    }

    public function setIsAllowedToOutput(bool $is): self
    {
        $this->isAllowedToOutput = $is;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }
}