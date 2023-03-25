<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class FromEnum implements ConstraintInterface
{
    public function __construct(
        public readonly string $enum
    ) {
    }

    public function getType(): string
    {
        return ValueConverterConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return FromEnumHandler::class;
    }
}
