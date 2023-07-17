<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Count implements DecoratorInterface
{
    public function getHandler(): string
    {
        return CountHandler::class;
    }
}