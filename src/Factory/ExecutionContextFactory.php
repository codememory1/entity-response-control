<?php

namespace Codememory\EntityResponseControl\Factory;

use Codememory\EntityResponseControl\Context\ExecutionContext;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\Reflectors\PropertyReflector;
use function Symfony\Component\String\u;

final class ExecutionContextFactory implements ExecutionContextFactoryInterface
{
    public function createExecutionContext(ResponsePrototypeInterface $responsePrototype, PropertyReflector $property, object $prototypeObject): ExecutionContextInterface
    {
        $context = new ExecutionContext($responsePrototype, $property, $prototypeObject);
        $configuration = $responsePrototype->getConfiguration();

        $context->setSkipThisProperty(false);
        $context->setNameGetterToGetValueFromObject(u("get_{$property->getName()}")->camel());
        $context->setResponseKey($configuration->getResponseKeyNamingStrategy()->convert($property->getName()));

        if (method_exists($prototypeObject, $context->getNameGetterToGetValueFromObject())) {
            $context->setValue($prototypeObject->{$context->getNameGetterToGetValueFromObject()}());
        } else {
            $context->setValue($property->getDefaultValue());
        }

        return $context;
    }
}