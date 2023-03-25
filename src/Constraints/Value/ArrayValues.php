<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ArrayValues implements ConstraintInterface
{
    public function __construct(
        public readonly string $key
    ) {
    }

    public function getType(): string
    {
        return ValueConverterConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return ArrayValuesHandler::class;
    }
}