<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Attribute;
use Codememory\EntityResponseControl\Decorators\Prototype\CallbackHandler;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Callback implements PropertyDecoratorInterface
{
    public function __construct(
        public array|string $callback
    ) {
    }

    public function getHandler(): string
    {
        return CallbackHandler::class;
    }
}