<?php

namespace Codememory\EntityResponseControl\Context;

use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyWrapperInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;
use function sprintf;

class PropertyExecutionContext implements PropertyExecutionContextInterface
{
    private ?PropertyWrapperInterface $propertyWrapper = null;
    private ?object $objectData = null;
    private ?array $getterNames = null;
    private bool $ignore = false;
    private ?string $collectedKey = null;
    private mixed $value;

    public function __construct(
        private readonly PrototypeExecutionContextInterface $prototypeExecutionContext
    ) {
    }

    public function setup(PropertyWrapperInterface $propertyWrapper, object $objectData): static
    {
        $this->propertyWrapper = $propertyWrapper;
        $this->objectData = $objectData;
        $this->collectedKey = $propertyWrapper->getName();

        return $this;
    }

    public function clear(): PropertyExecutionContextInterface
    {
        $this->getterNames = null;
        $this->ignore = false;
        $this->collectedKey = null;

        if (isset($this->value)) {
            $this->value = null;
        }

        return $this;
    }

    public function getPrototypeExecutionContext(): PrototypeExecutionContextInterface
    {
        return $this->prototypeExecutionContext;
    }

    public function getPropertyWrapper(): PropertyWrapperInterface
    {
        return $this->propertyWrapper;
    }

    public function getObjectData(): object
    {
        return $this->objectData;
    }

    public function getGetterNames(): array
    {
        if (null === $this->getterNames) {
            return [
                sprintf('get%s', mb_ucfirst($this->propertyWrapper->getName())),
                sprintf('is%s', mb_ucfirst($this->propertyWrapper->getName()))
            ];
        }

        return $this->getterNames;
    }

    public function setGetterNames(?array $names): PropertyExecutionContextInterface
    {
        $this->getterNames = $names;

        return $this;
    }

    public function isIgnore(): bool
    {
        return $this->ignore;
    }

    public function setIgnore(bool $ignore): PropertyExecutionContextInterface
    {
        $this->ignore = $ignore;

        return $this;
    }

    public function getValue(): mixed
    {
        if (isset($this->value)) {
            return $this->value;
        }

        foreach ($this->getGetterNames() as $getterName) {
            if (method_exists($this->objectData, $getterName)) {
                return $this->objectData->{$getterName}();
            }
        }

        return $this->propertyWrapper->getPropertyReflector()->getDefaultValue();
    }

    public function setValue(mixed $value): PropertyExecutionContextInterface
    {
        $this->value = $value;

        return $this;
    }

    public function getCollectedKey(): string
    {
        return $this->collectedKey;
    }

    public function setCollectedKey(string $key): static
    {
        $this->collectedKey = $key;

        return $this;
    }
}