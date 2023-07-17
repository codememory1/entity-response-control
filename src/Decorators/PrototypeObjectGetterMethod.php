<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class PrototypeObjectGetterMethod implements DecoratorInterface
{
    public function __construct(
        public readonly string $name
    ) {
    }

    public function getHandler(): string
    {
        return PrototypeObjectGetterMethodHandler::class;
    }
}