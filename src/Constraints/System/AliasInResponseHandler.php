<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;

final class AliasInResponseHandler implements SystemConstraintHandlerInterface
{
    /**
     * @param AliasInResponse $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        $constraintTypeControl->setPropertyNameInResponse($constraint->alias);

        return true;
    }
}