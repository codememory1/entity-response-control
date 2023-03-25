<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTime implements ConstraintInterface
{
    public function __construct(
        public readonly string $format = 'Y-m-d H:i:s',
        public readonly bool $full = false
    ) {
    }

    public function getType(): string
    {
        return ValueConverterConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return DateTimeHandler::class;
    }
}