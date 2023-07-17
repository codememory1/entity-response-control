<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\PropertyReflector;

interface CollectorInterface
{
    /**
     * @param array<int, PropertyReflector> $properties
     */
    public function collect(ResponsePrototypeInterface $responsePrototype, object $prototypeObject, array $properties): array;
}