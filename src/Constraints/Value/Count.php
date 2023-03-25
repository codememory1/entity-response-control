<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Count implements ConstraintInterface
{
    public function getType(): string
    {
        return ValueConverterConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return CountHandler::class;
    }
}