<?php

namespace Codememory\EntityResponseControl\Decorators\Prototype;

use Codememory\EntityResponseControl\Interfaces\PropertyWrapperInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;

class IgnorePropertiesHandler implements PrototypeDecoratorHandlerInterface
{
    /**
     * @param IgnoreProperties $decorator
     */
    public function process(PrototypeDecoratorInterface $decorator, PrototypeExecutionContextInterface $executionContext): void
    {
        $executionContext->setPropertyWrappers(array_filter(
            $executionContext->getPropertyWrappers(),
            static fn (PropertyWrapperInterface $wrapper) => !in_array($wrapper->getName(), $decorator->names, true)
        ));
    }
}