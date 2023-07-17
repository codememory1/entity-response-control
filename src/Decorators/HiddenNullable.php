<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
final class HiddenNullable implements DecoratorInterface
{
    public function __construct(
        public readonly bool $ignoreEmptyString = true
    ) {
    }

    public function getHandler(): string
    {
        return HiddenNullableHandler::class;
    }
}