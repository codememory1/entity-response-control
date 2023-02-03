<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class PrefixConstraint implements ConstraintInterface
{
    public function __construct(
        public readonly ?string $method = null,
        public readonly ?string $response = null
    ) {
    }

    public function getHandler(): string
    {
        return PrefixConstraintHandler::class;
    }
}