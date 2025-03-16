<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Decorators\Prototype\CallbackHandler;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;

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