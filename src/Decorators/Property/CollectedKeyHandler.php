<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;

class CollectedKeyHandler implements PropertyDecoratorHandlerInterface
{
    /**
     * @param CollectedKey $decorator
     */
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        $executionContext->setCollectedKey($decorator->key);
    }
}