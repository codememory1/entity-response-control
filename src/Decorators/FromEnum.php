<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class FromEnum implements DecoratorInterface
{
    public function __construct(
        public readonly ?string $enum = null // If value is string, argument is required
    ) {
    }

    public function getHandler(): string
    {
        return FromEnumHandler::class;
    }
}
