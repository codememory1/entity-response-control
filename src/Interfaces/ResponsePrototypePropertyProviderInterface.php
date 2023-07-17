<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\ClassReflector;
use Codememory\Reflection\Reflectors\PropertyReflector;

interface ResponsePrototypePropertyProviderInterface
{
    /**
     * @return array<int, PropertyReflector>
     */
    public function getProperties(ClassReflector $classReflector): array;

    /**
     * @param callable(array<int, PropertyReflector> $properties): array<int, PropertyReflector> $callback
     *
     * The callback must fire before getProperties returns. The callback takes an array argument from getProperties and should return an array with a return type of getProperties
     */
    public function setExtension(callable $callback): self;
}