<?php

namespace Codememory\EntityResponseControl\Context;

use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;
use function Symfony\Component\String\u;

final class ExecutionContext implements ExecutionContextInterface
{
    private string $responseKey;
    private string $nameGetterToGetValueFromObject;
    private mixed $value = null;
    private bool $skippedThisProperty = false;

    public function __construct(
        private readonly ResponsePrototypeInterface $responsePrototype,
        private readonly PropertyReflector $property,
        private readonly object $prototypeObject
    ) {
        $this->responseKey = $this->responsePrototype->getConfiguration()->getResponseKeyNamingStrategy()->convert($this->property->getName());
        $this->nameGetterToGetValueFromObject = u("get_{$this->property->getName()}")->camel();
    }

    public function getResponsePrototype(): ResponsePrototypeInterface
    {
        return $this->responsePrototype;
    }

    public function getProperty(): PropertyReflector
    {
        return $this->property;
    }

    public function getResponseKey(): string
    {
        return $this->responseKey;
    }

    public function setResponseKey(string $name): ExecutionContextInterface
    {
        $this->responseKey = $name;

        return $this;
    }

    public function getNameGetterToGetValueFromObject(): string
    {
        return $this->nameGetterToGetValueFromObject;
    }

    public function setNameGetterToGetValueFromObject(string $name): ExecutionContextInterface
    {
        $this->nameGetterToGetValueFromObject = $name;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): ExecutionContextInterface
    {
        $this->value = $value;

        return $this;
    }

    public function getPrototypeObject(): object
    {
        return $this->prototypeObject;
    }

    public function isSkippedThisProperty(): bool
    {
        return $this->skippedThisProperty;
    }

    public function setSkipThisProperty(bool $skip): ExecutionContextInterface
    {
        $this->skippedThisProperty = $skip;

        return $this;
    }
}