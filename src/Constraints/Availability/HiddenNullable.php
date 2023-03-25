<?php

namespace Codememory\EntityResponseControl\Constraints\Availability;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\AvailabilityConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
final class HiddenNullable implements ConstraintInterface
{
    public function __construct(
        public readonly bool $ignoreEmptyString = true
    ) {
    }

    public function getType(): string
    {
        return AvailabilityConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return HiddenNullableHandler::class;
    }
}