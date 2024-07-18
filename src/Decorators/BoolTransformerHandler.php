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
        $context->setValue(true === $context->getValue() ? $decorator->trueAs : $decorator->falseAs);
    }
}