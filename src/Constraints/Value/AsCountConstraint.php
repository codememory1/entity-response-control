<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AsCountConstraint implements ConstraintInterface
{
    public function getHandler(): string
    {
        return AsCountConstraintHandler::class;
    }
}