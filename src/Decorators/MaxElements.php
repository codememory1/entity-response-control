<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MaxElements implements DecoratorInterface
{
    public function __construct(
        public readonly int $max
    ) {
    }

    public function getHandler(): string
    {
        return MaxElementsHandler::class;
    }
}