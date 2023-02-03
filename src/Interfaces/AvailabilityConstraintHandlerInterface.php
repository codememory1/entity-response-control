<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\ConstraintTypeControl;

interface AvailabilityConstraintHandlerInterface extends ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool;
}