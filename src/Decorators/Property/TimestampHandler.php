<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use DateTimeInterface;

class TimestampHandler implements PropertyDecoratorHandlerInterface
{
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        if ($executionContext->getValue() instanceof DateTimeInterface) {
            $executionContext->setValue($executionContext->getValue()->getTimestamp());
        }
    }
}