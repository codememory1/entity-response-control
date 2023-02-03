<?php

namespace Codememory\EntityResponseControl\ConstraintTypeHandlers;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\AvailabilityConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;

final class AvailabilityConstraintHandler implements ConstraintTypeHandlerInterface
{
    public function handle(ConstraintTypeControl $constraintTypeControl, ConstraintInterface $constraint, ConstraintHandlerInterface $handler): void
    {
        if ($handler instanceof AvailabilityConstraintHandlerInterface) {
            if (false === $handler->handle($constraint, $constraintTypeControl)) {
                $constraintTypeControl->setIsAllowedToOutput(false);
            }
        }
    }
}