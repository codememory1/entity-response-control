<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;

class FromMetadataHandler implements PropertyDecoratorHandlerInterface
{
    /**
     * @param FromObjectMetadata $decorator
     */
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        $getterValue = $executionContext->getObjectData()->{$decorator->getterValueAsKey}();
        $metadata = $executionContext->getPrototypeExecutionContext()->getMetadata();

        if (null !== $decorator->fromKey) {
            $metadata = $executionContext->getPrototypeExecutionContext()->getMetadata()[$decorator->fromKey] ?? [];
        }

        if (array_key_exists($getterValue, $metadata)) {
            $executionContext->setValue($metadata[$getterValue]);
        }
    }
}