<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use RuntimeException;

class CallbackHandler implements PropertyDecoratorHandlerInterface
{
    /**
     * @param Callback $decorator
     */
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        $className = $this->getClassName($decorator, $executionContext);
        $methodName = $this->getMethodName($decorator, $executionContext);

        if (!method_exists($className, $methodName)) {
            throw new RuntimeException("Method '{$methodName}' does not exist in class '{$className}'.");
        }
        
        $executionContext->setValue($className::{$methodName}($executionContext));
    }

    private function getClassName(Callback $decorator, PropertyExecutionContextInterface $executionContext): string
    {
        if (is_array($decorator->callback)) {
            return $decorator->callback[0];
        }

        return $executionContext->getPrototypeExecutionContext()->getClassReflector()->getName();
    }

    private function getMethodName(Callback $decorator, PropertyExecutionContextInterface $executionContext): string
    {
        if (is_array($decorator->callback)) {
            return $decorator->callback[1];
        }

        return $decorator->callback;
    }
}