<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class BoolTransformer implements DecoratorInterface
{
    public function __construct(
        public readonly mixed $trueAs,
        public readonly mixed $falseAs
    ) {
    }

    public function getHandler(): string
    {
        return BoolTransformerHandler::class;
    }
}