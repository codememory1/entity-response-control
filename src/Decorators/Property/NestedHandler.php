<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use function is_array;
use function is_object;

class NestedHandler implements PropertyDecoratorHandlerInterface
{
    /**
     * @param Nested $decorator
     */
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        $manager = $executionContext->getPrototypeExecutionContext()->getManager();

        if (is_object($executionContext->getValue()) || is_array($executionContext->getValue())) {
            $executionContext->setValue($manager->collect(
                $decorator->prototype,
                $executionContext->getValue(),
                $decorator->decorators,
                [...$decorator->metadata, ...$executionContext->getPrototypeExecutionContext()->getMetadata()]
            ));
        } else {
            $executionContext->setValue($executionContext->getPropertyWrapper()->getPropertyReflector()->getDefaultValue());
        }
    }
}