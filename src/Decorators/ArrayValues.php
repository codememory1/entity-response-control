<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ArrayValues implements DecoratorInterface
{
    public function __construct(
        public readonly string $key
    ) {
    }

    public function getHandler(): string
    {
        return ArrayValuesHandler::class;
    }
}