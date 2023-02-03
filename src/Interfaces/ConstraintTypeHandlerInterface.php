<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\ConstraintTypeControl;

interface ConstraintTypeHandlerInterface
{
    public function handle(ConstraintTypeControl $constraintTypeControl, ConstraintInterface $constraint, ConstraintHandlerInterface $handler): void;
}