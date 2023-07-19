<?php

namespace Codememory\EntityResponseControl\Collectors;

use Codememory\EntityResponseControl\Interfaces\CollectorInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;

final class BaseCollector implements CollectorInterface
{
    public function collect(ResponsePrototypeInterface $responsePrototype, object $prototypeObject, array $properties): array
    {
        $collectedData = [];

        foreach ($properties as $property) {
            if ($property instanceof PropertyReflector) {
                $context = $responsePrototype->getExecutionContextFactory()->createExecutionContext($responsePrototype, $property, $prototypeObject);

                $this->propertyAttributesHandler($property, $context);

                if ($context->isSkippedThisProperty()) {
                    continue;
                }

                $collectedData[$context->getResponseKey()] = $context->getValue();
            }
        }

        return $collectedData;
    }

    private function propertyAttributesHandler(PropertyReflector $property, ExecutionContextInterface $context): void
    {
        foreach ($property->getAttributes() as $attribute) {
            /** @var DecoratorInterface $decorator */
            $decorator = $attribute->getInstance();

            if ($decorator instanceof DecoratorInterface) {
                $this->propertyAttributeHandler($decorator, $context);

                if ($context->isSkippedThisProperty()) {
                    break;
                }
            }
        }
    }

    private function propertyAttributeHandler(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $context
            ->getResponsePrototype()
            ->getDecoratorHandlerRegistrar()
            ->getHandler($decorator->getHandler())
            ->handle($decorator, $context);
    }
}