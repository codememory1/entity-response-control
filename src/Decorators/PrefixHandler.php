<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Exception\MethodNotFoundException;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use function Symfony\Component\String\u;

final class PrefixHandler implements DecoratorHandlerInterface
{
    /**
     * @param Prefix $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $prototype = $context->getResponsePrototype();
        $propertyName = $context->getProperty()->getName();

        if (null !== $decorator->prototypeObject) {
            $context->setNameGetterToGetValueFromObject(u("{$decorator->prototypeObject}_{$propertyName}")->camel());

            if (!method_exists($context->getPrototypeObject(), $context->getNameGetterToGetValueFromObject())) {
                throw new MethodNotFoundException($context->getPrototypeObject(), $context->getNameGetterToGetValueFromObject());
            }

            $context->setValue($context->getPrototypeObject()->{$context->getNameGetterToGetValueFromObject()}());
        }

        if (null !== $decorator->response) {
            $context->setResponseKey($prototype->getConfiguration()->getResponseKeyNamingStrategy()->convert("{$decorator->response}_{$propertyName}"));
        }
    }
}