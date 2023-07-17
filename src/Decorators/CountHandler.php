<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Countable;
use function is_array;
use function is_string;

final class CountHandler implements DecoratorHandlerInterface
{
    /**
     * @param Count $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        if (is_array($context->getValue())) {
            $context->setValue(count($context->getValue()));
        } else if ($context->getValue() instanceof Countable) {
            $context->setValue($context->getValue()->count());
        } else if (is_string($context->getValue())) {
            $context->setValue(mb_strlen($context->getValue()));
        } else {
            $context->setValue((int) $context->getValue());
        }
    }
}