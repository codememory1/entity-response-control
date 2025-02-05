<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\ClassReflector;

interface PrototypeExecutionContextInterface
{
    public function getManager(): ResponsePrototypeManagerInterface;

    public function getClassReflector(): ClassReflector;

    /**
     * @return array<int, PropertyWrapperInterface>
     */
    public function getPropertyWrappers(): array;

    /**
     * @param array<int, PropertyWrapperInterface> $wrappers
     */
    public function setPropertyWrappers(array $wrappers): static;

    /**
     * @return array<int, object>|object
     */
    public function getData(): array|object;

    /**
     * @param array<int, object>|object $data
     */
    public function setData(array|object $data): static;

    public function getMetadata(): array;

    public function setMetadata(array $metadata): static;
}