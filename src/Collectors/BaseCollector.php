<?php

namespace Codememory\EntityResponseControl\Collectors;

use Codememory\EntityResponseControl\Exceptions\ResponsePrototypeException;
use Codememory\EntityResponseControl\Interfaces\CollectorInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorRegistrarInterface;
use Codememory\EntityResponseControl\Interfaces\NamingStrategyInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use Codememory\Reflection\Reflectors\AttributeReflector;

readonly class BaseCollector implements CollectorInterface
{
    public function __construct(
        private DecoratorRegistrarInterface $decoratorRegistrar,
        private NamingStrategyInterface $namingStrategy
    ) {
    }

    /**
     * @throws ResponsePrototypeException
     */
    public function collect(PropertyExecutionContextInterface $executionContext, object $object): array
    {
        return $this->doCollect($executionContext, $object);
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function doCollect(PropertyExecutionContextInterface $executionContext, object $object): array
    {
        $collected = [];

        foreach ($executionContext->getPrototypeExecutionContext()->getPropertyWrappers() as $propertyWrapper) {
            $executionContext->setup($propertyWrapper, $object);

            foreach ($executionContext->getPropertyWrapper()->getAttributes() as $attribute) {
                $attributeInstance = $attribute instanceof AttributeReflector ? $attribute->getInstance() : $attribute;

                if ($attributeInstance instanceof PropertyDecoratorInterface) {
                    $this->getDecoratorHandler($executionContext, $attributeInstance)->process($attributeInstance, $executionContext);
                }
            }

            if (!$executionContext->isIgnore()) {
                $collected[$this->getCollectedKey($executionContext)] = $executionContext->getValue();
            }

            $executionContext->clear();
        }

        return $collected;
    }

    private function getCollectedKey(PropertyExecutionContextInterface $executionContext): string
    {
        return $this->namingStrategy->propertyNameToCollectedKey($executionContext->getCollectedKey());
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function getDecoratorHandler(PropertyExecutionContextInterface $executionContext, DecoratorInterface $decorator): DecoratorHandlerInterface
    {
        if (!$this->decoratorRegistrar->existsHandler($decorator->getHandler())) {
            $decoratorClassName = $decorator::class;

            throw new ResponsePrototypeException($executionContext->getPrototypeExecutionContext()->getClassReflector()->getName(), "The \"{$decorator->getHandler()}\" handler for the \"{$decoratorClassName}\" decorator is not registered.");
        }

        return $this->decoratorRegistrar->getHandler($decorator->getHandler());
    }
}