<?php

namespace Codememory\EntityResponseControl\Factory;

use Codememory\EntityResponseControl\Interfaces\PropertyWrapperFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyWrapperInterface;
use Codememory\EntityResponseControl\Wrappers\PropertyWrapper;
use Codememory\Reflection\Reflectors\PropertyReflector;

class PropertyWrapperFactory implements PropertyWrapperFactoryInterface
{
    public function create(PropertyReflector $propertyReflector): PropertyWrapperInterface
    {
        return new PropertyWrapper($propertyReflector);
    }
}