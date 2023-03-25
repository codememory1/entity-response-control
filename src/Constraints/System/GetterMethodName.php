<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\SystemConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class GetterMethodName implements ConstraintInterface
{
    public function __construct(
        public readonly string $name
    ) {
    }

    public function getType(): string
    {
        return SystemConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return GetterMethodNameHandler::class;
    }
}