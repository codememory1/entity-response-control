<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;
use LogicException;

final class AsCustomConstraintHandler implements SystemConstraintHandlerInterface
{
    /**
     * @param AsCustomConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        $constraintTypeControl->setValue(null);

        if (!method_exists($constraintTypeControl->responseControl, $constraint->methodName)) {
            $responseControlNamespace = $constraintTypeControl->responseControl::class;

            throw new LogicException("Method {$constraint->methodName} not exist in ResponseControl {$responseControlNamespace}");
        }

        $result = $constraintTypeControl->responseControl->{$constraint->methodName}(
            $constraintTypeControl->object,
            $constraintTypeControl->getValue()
        );

        $constraintTypeControl->setValue($result);

        return true;
    }
}