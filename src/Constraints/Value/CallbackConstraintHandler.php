<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use LogicException;

final class CallbackConstraintHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param CallbackConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        if (!method_exists($constraintTypeControl->responseControl, $constraint->methodName)) {
            $responseControlNamespace = $constraintTypeControl->responseControl::class;

            throw new LogicException("Method {$constraint->methodName} not exist in ResponseControl {$responseControlNamespace}");
        }

        return $constraintTypeControl->responseControl->{$constraint->methodName}(
            $constraintTypeControl->object,
            $constraintTypeControl->getValue()
        );
    }
}