<?php

namespace Codememory\EntityResponseControl\ConstraintTypeHandlers;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;

final class ValueConverterConstraintHandler implements ConstraintTypeHandlerInterface
{
    public function handle(ConstraintTypeControl $constraintTypeControl, ConstraintInterface $constraint, ConstraintHandlerInterface $handler): void
    {
        if ($handler instanceof ValueConverterConstraintHandlerInterface) {
            $constraintTypeControl->setValue($handler->handle($constraint, $constraintTypeControl));
        }
    }
}