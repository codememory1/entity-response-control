<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Exception\MethodNotFoundException;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class CustomHandler implements DecoratorHandlerInterface
{
    /**
     * @param Custom $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $context->setValue($context->getProperty()->getDefaultValue());

        if (!method_exists($context->getResponsePrototype(), $decorator->methodName)) {
            throw new MethodNotFoundException($context->getResponsePrototype(), $decorator->methodName);
        }

        $context->setValue($context->getResponsePrototype()->{$decorator->methodName}(
            $context->getPrototypeObject(),
            $context->getValue()
        ));
    }
}