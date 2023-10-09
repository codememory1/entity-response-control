<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Exception\ResponsePrototypeNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConfigurationInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;
use function is_array;
use function is_object;

final class NestedPrototypeHandler implements DecoratorHandlerInterface
{
    /**
     * @param NestedPrototype $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $value = $context->getValue();

        if (false === class_exists($decorator->prototype)) {
            throw new ResponsePrototypeNotFoundException($decorator->prototype);
        }

        if (!is_array($value) && !is_object($value)) {
            $context->setValue($context->getProperty()->getDefaultValue());
        }

        $prototype = $this->createPrototype($decorator, $context);

        $this->skipProperties($decorator, $prototype->getConfiguration());
        $this->skipAllPropertiesExpect($decorator, $prototype->getConfiguration());

        if (null === $value) {
            $context->setValue($context->getProperty()->getDefaultValue());
        } else {
            $context->setValue($prototype->collect($value)->toArray());
        }
    }

    private function skipProperties(NestedPrototype $decorator, ConfigurationInterface $configuration): void
    {
        if ([] !== $decorator->skipProperties && [] === $decorator->skipAllPropertiesExpect) {
            $configuration
                ->getResponsePrototypePropertyProvider()
                ->setExtension(static fn (array $properties) => array_filter(
                    $properties,
                    static fn (PropertyReflector $property) => !in_array($property->getName(), $decorator->skipProperties, true)
                ));
        }
    }

    private function skipAllPropertiesExpect(NestedPrototype $decorator, ConfigurationInterface $configuration): void
    {
        if ([] !== $decorator->skipAllPropertiesExpect && [] === $decorator->skipProperties) {
            $configuration
                ->getResponsePrototypePropertyProvider()
                ->setExtension(static fn (array $properties) => array_filter(
                    $properties,
                    static fn (PropertyReflector $property) => in_array($property->getName(), $decorator->skipAllPropertiesExpect, true)
                ));
        }
    }

    private function createPrototype(NestedPrototype $decorator, ExecutionContextInterface $context): ResponsePrototypeInterface
    {
        return new ($decorator->prototype)(
            $context->getResponsePrototype()->getCollector(),
            $context->getResponsePrototype()->getConfigurationFactory(),
            $context->getResponsePrototype()->getExecutionContextFactory(),
            $context->getResponsePrototype()->getDecoratorHandlerRegistrar(),
            $context->getResponsePrototype()->getReflectorManager()
        );
    }
}