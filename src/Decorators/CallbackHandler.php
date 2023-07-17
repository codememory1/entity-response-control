<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Exception\MethodNotFoundException;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class CallbackHandler implements DecoratorHandlerInterface
{
    /**
     * @param Callback $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        if (!method_exists($context->getProperty(), $decorator->methodName)) {
            throw new MethodNotFoundException($context->getProperty(), $decorator->methodName);
        }

        $context->setValue($context->getProperty()->{$decorator->methodName}(
            $context->getPrototypeObject(),
            $context->getValue()
        ));
    }
}