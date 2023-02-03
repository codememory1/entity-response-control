<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AliasInResponseConstraint implements ConstraintInterface
{
    public function __construct(
        public readonly string $alias
    ) {
    }

    public function getHandler(): string
    {
        return AliasInResponseConstraintHandler::class;
    }
}