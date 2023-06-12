<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Exception\MethodNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;

final class CallbackHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param Callback $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        if (!method_exists($constraintTypeControl->responseControl, $constraint->methodName)) {
            throw new MethodNotFoundException($constraintTypeControl->responseControl, $constraint->methodName);
        }

        return $constraintTypeControl->responseControl->{$constraint->methodName}(
            $constraintTypeControl->object,
            $constraintTypeControl->getValue()
        );
    }
}