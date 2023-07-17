<?php

namespace Codememory\EntityResponseControl\Decorators;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class NestedPrototype implements DecoratorInterface
{
    public function __construct(
        public readonly string $prototype,
        public readonly array $skipProperties = [],
        public readonly array $skipAllPropertiesExpect = []
    ) {
    }

    public function getHandler(): string
    {
        return NestedPrototypeHandler::class;
    }
}