<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use DateTimeInterface;

final class DateTimeConstraintHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param DateTimeConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        if ($constraintTypeControl->getValue() instanceof DateTimeInterface || null === $constraintTypeControl->getValue()) {
            return $constraintTypeControl->getValue()?->format($constraint->format);
        }

        return null;
    }
}