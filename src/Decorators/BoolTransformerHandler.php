<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class BoolTransformerHandler implements DecoratorHandlerInterface
{
    /**
     * @param BoolTransformer $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        if (true === $context->getValue()) {
            $context->setValue($decorator->trueAs);
        } else {
            $context->setValue($decorator->falseAs);
        }
    }
}