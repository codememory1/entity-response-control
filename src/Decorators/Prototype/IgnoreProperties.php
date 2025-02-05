<?php

namespace Codememory\EntityResponseControl\Decorators\Prototype;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class IgnoreProperties implements PrototypeDecoratorInterface
{
    public function __construct(
        public array $names
    ) {
    }

    public function getHandler(): string
    {
        return IgnorePropertiesHandler::class;
    }
}