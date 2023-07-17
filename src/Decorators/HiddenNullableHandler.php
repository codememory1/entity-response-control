<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use function is_string;

final class HiddenNullableHandler implements DecoratorHandlerInterface
{
    /**
     * @param HiddenNullable $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        if (null === $context->getValue()) {
            $context->setSkipThisProperty(null === $context->getValue());
        } else if (!$decorator->ignoreEmptyString && $this->isEmptyString($context)) {
            $context->setSkipThisProperty(true);
        }
    }

    private function isEmptyString(ExecutionContextInterface $context): bool
    {
        return is_string($context->getValue()) && 1 === preg_match('/^\s*$/', $context->getValue());
    }
}