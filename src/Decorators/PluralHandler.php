<?php

namespace Codememory\EntityResponseControl\Decorators;

use function call_user_func;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class PluralHandler implements DecoratorHandlerInterface
{
    /**
     * @param Plural $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $value = $context->getValue();
        $defaultValue = $context->getProperty()->getDefaultValue();

        if (empty($value)) {
            $context->setValue($defaultValue);
        } else {
            $word = $decorator->word2;

            if ($value % 10 >= 5 || 0 === $value % 10 || ($value % 100 >= 11 && $value % 100 <= 19)) {
                $word = $decorator->word5;
            } else if (1 === $value % 10) {
                $word = $decorator->word1;
            }

            if (false === $decorator->callback) {
                $context->setValue("{$value} {$word}");
            } else {
                $context->setValue(call_user_func($decorator->callback, $context->getPrototypeObject(), $word));
            }
        }
    }
}