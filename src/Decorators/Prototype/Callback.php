<?php

namespace Codememory\EntityResponseControl\Decorators\Prototype;

use Attribute;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;

#[Attribute(Attribute::TARGET_CLASS)]
class Callback implements PrototypeDecoratorInterface
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