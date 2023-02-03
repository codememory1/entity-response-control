<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;

final class AliasInResponseConstraintHandler implements SystemConstraintHandlerInterface
{
    /**
     * @param AliasInResponseConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        $constraintTypeControl->setPropertyNameInResponse($constraint->alias);

        return true;
    }
}