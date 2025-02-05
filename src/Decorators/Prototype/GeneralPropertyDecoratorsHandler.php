<?php

namespace Codememory\EntityResponseControl\Decorators\Prototype;

use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;

class GeneralPropertyDecoratorsHandler implements PrototypeDecoratorHandlerInterface
{
    /**
     * @param GeneralPropertyDecorators $decorator
     */
    public function process(PrototypeDecoratorInterface $decorator, PrototypeExecutionContextInterface $executionContext): void
    {
        foreach ($executionContext->getPropertyWrappers() as $propertyWrapper) {
            $propertyWrapper->addAttribute(...$decorator->decorators);
        }
    }
}