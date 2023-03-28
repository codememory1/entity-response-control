<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;

final class BooleanToHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param BooleanTo $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        $value = $constraintTypeControl->getValue();

        if (empty($value)) {
            return $constraint->falseAs;
        }

        return true === $value ? $constraint->trueAs : $constraint->falseAs;
    }
}