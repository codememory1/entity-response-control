<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class PrototypeObjectGetterMethodHandler implements DecoratorHandlerInterface
{
    private const RESERVED_KEYS = [
        '{name}' // Capitalized property name
    ];

    /**
     * @param PrototypeObjectGetterMethod $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $name = str_replace(self::RESERVED_KEYS, [
            ucfirst($context->getProperty()->getName())
        ], $decorator->name);

        $context->setNameGetterToGetValueFromObject($name);
        $context->setValue($context->getPrototypeObject()->{$context->getNameGetterToGetValueFromObject()}());
    }
}