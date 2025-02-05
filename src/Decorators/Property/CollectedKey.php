<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class CollectedKey implements PropertyDecoratorInterface
{
    public function __construct(
        public string $key
    ) {
    }

    public function getHandler(): string
    {
        return CollectedKeyHandler::class;
    }
}