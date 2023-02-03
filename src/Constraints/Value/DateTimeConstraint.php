<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTimeConstraint implements ConstraintInterface
{
    public function __construct(
        public readonly string $format = 'Y-m-d H:i:s'
    ) {
    }

    public function getHandler(): string
    {
        return DateTimeConstraintHandler::class;
    }
}