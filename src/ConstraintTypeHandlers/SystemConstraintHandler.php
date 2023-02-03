<?php

namespace Codememory\EntityResponseControl\ConstraintTypeHandlers;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintTypeHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;

final class SystemConstraintHandler implements ConstraintTypeHandlerInterface
{
    public function handle(ConstraintTypeControl $constraintTypeControl, ConstraintInterface $constraint, ConstraintHandlerInterface $handler): void
    {
        if ($handler instanceof SystemConstraintHandlerInterface) {
            $handler->handle($constraint, $constraintTypeControl);
        }
    }
}