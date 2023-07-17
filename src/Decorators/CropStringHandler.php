<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;

final class CropStringHandler implements DecoratorHandlerInterface
{
    /**
     * @param CropString $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $value = $context->getValue();

        if (!empty($value) && mb_strlen($value, 'UTF-8') > $decorator->maxlength) {
            $context->setValue(trim(mb_substr($value, 0, $decorator->maxlength)) . $decorator->end);
        } else {
            $context->setValue($value);
        }
    }
}