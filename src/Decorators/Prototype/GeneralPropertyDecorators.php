<?php

namespace Codememory\EntityResponseControl\Decorators\Prototype;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class GeneralPropertyDecorators implements PrototypeDecoratorInterface
{
    /**
     * @param array<int, PropertyDecoratorInterface> $decorators
     */
    public function __construct(
        public array $decorators = []
    ) {
    }

    public function getHandler(): string
    {
        return GeneralPropertyDecoratorsHandler::class;
    }
}