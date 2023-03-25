<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Exception\MethodNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;

final class CustomHandler implements SystemConstraintHandlerInterface
{
    /**
     * @param Custom $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        $constraintTypeControl->setValue(null);

        if (!method_exists($constraintTypeControl->responseControl, $constraint->methodName)) {
            throw new MethodNotFoundException($constraintTypeControl->responseControl, $constraint->methodName);
        }

        $result = $constraintTypeControl->responseControl->{$constraint->methodName}(
            $constraintTypeControl->object,
            $constraintTypeControl->getValue()
        );

        $constraintTypeControl->setValue($result);

        return true;
    }
}