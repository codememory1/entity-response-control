<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use Countable;
use function is_array;
use function is_string;

class LengthHandler implements PropertyDecoratorHandlerInterface
{
    /**
     * @param Length $decorator
     */
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        if (is_array($executionContext->getValue()) || $executionContext->getValue() instanceof Countable) {
            $executionContext->setValue(count($executionContext->getValue()));
        } else if (is_string($executionContext->getValue())) {
            $executionContext->setValue(mb_strlen($executionContext->getValue()));
        }
    }
}