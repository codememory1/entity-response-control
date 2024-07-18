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
        if (!method_exists($context->getResponsePrototype(), $decorator->methodName)) {
            throw new MethodNotFoundException($context->getResponsePrototype(), $decorator->methodName);
        }

        $context->setValue(
            $context
                ->getResponsePrototype()
                ->getClassReflector()
                ->getMethodByName($decorator->methodName)
                ->invoke(
                    $context->getResponsePrototype(),
                    $context->getPrototypeObject(),
                    $context->getValue()
                )
        );
    }
}