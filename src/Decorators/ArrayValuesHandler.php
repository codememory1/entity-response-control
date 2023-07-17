<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use function is_array;
use function is_object;

final class ArrayValuesHandler implements DecoratorHandlerInterface
{
    /**
     * @param ArrayValues $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $values = [];

        foreach ($context->getValue() as $item) {
            if (is_object($item) && method_exists($item, $decorator->key)) {
                $values[] = $item->{$decorator->key}();
            } else if (is_array($item) && array_key_exists($decorator->key, $item)) {
                $values[] = $item[$decorator->key];
            }
        }

        $context->setValue($values);
    }
}