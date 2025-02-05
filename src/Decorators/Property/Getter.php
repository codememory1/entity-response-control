<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class Getter implements PropertyDecoratorInterface
{
    public function __construct(
        public array $names
    ) {
    }

    public function getHandler(): string
    {
        return GetterHandler::class;
    }
}