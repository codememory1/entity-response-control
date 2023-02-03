<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\ConstraintTypeControl;

interface ConstraintHandlerInterface
{
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed;
}