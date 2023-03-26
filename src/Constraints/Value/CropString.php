<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\ValueConverterConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CropString implements ConstraintInterface
{
    public function __construct(
        public readonly int $maxlength,
        public readonly string $end = '...'
    ) {
    }

    public function getType(): string
    {
        return ValueConverterConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return CropStringHandler::class;
    }
}