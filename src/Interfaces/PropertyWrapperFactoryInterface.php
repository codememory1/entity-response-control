<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\Reflectors\PropertyReflector;

interface PropertyWrapperFactoryInterface
{
    public function create(PropertyReflector $propertyReflector): PropertyWrapperInterface;
}