<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Length implements PropertyDecoratorInterface
{
    public function getHandler(): string
    {
        return LengthHandler::class;
    }
}