<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\PropertyReflector;

interface ExecutionContextFactoryInterface
{
    public function createExecutionContext(ResponsePrototypeInterface $responsePrototype, PropertyReflector $property, object $prototypeObject): ExecutionContextInterface;
}