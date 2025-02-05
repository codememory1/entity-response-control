<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Nested implements PropertyDecoratorInterface
{
    public function __construct(
        public readonly string $prototype,
        public readonly array $decorators = [],
        public readonly array $metadata = []
    ) {
    }

    public function getHandler(): string
    {
        return NestedHandler::class;
    }
}