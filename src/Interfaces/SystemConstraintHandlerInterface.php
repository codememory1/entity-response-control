<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\ConstraintTypeControl;

interface SystemConstraintHandlerInterface extends ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed;
}