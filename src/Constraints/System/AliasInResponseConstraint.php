<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Attribute;
use Codememory\EntityResponseControl\ConstraintTypeHandlers\SystemConstraintHandler;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AliasInResponseConstraint implements ConstraintInterface
{
    public function __construct(
        public readonly string $alias
    ) {
    }

    public function getType(): string
    {
        return SystemConstraintHandler::class;
    }

    public function getHandler(): string
    {
        return AliasInResponseConstraintHandler::class;
    }
}