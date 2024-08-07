<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class MaxElementsHandler implements DecoratorHandlerInterface
{
    /**
     * @param MaxElements $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $value = $context->getValue();

        $context->setValue(empty($value) ? [] : array_splice($value, 0, $decorator->max));
    }
}