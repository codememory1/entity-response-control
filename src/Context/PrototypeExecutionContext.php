<?php

namespace Codememory\EntityResponseControl\Context;

use Codememory\EntityResponseControl\Interfaces\PropertyWrapperFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeManagerInterface;
use Codememory\Reflection\Reflectors\ClassReflector;
use Codememory\Reflection\Reflectors\PropertyReflector;

class PrototypeExecutionContext implements PrototypeExecutionContextInterface
{
    private array $propertyWrappers;

    public function __construct(
        private readonly ResponsePrototypeManagerInterface $manager,
        private readonly PropertyWrapperFactoryInterface $propertyWrapperFactory,
        private readonly ClassReflector $classReflector,
        private array|object $data,
        private array $metadata
    ) {
        $this->propertyWrappers = array_map(
            fn (PropertyReflector $reflector) => $this->propertyWrapperFactory->create($reflector),
            $this->classReflector->getProperties()
        );
    }

    public function getManager(): ResponsePrototypeManagerInterface
    {
        return $this->manager;
    }

    public function getClassReflector(): ClassReflector
    {
        return $this->classReflector;
    }

    public function getPropertyWrappers(): array
    {
        return $this->propertyWrappers;
    }

    public function setPropertyWrappers(array $wrappers): static
    {
        $this->propertyWrappers = $wrappers;

        return $this;
    }

    public function getData(): array|object
    {
        return $this->data;
    }

    public function setData(array|object $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata): static
    {
        $this->metadata = $metadata;

        return $this;
    }
}