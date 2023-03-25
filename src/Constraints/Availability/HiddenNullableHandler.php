<?php

namespace Codememory\EntityResponseControl\Constraints\Availability;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\AvailabilityConstraintHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;

final class HiddenNullableHandler implements AvailabilityConstraintHandlerInterface
{
    /**
     * @param HiddenNullable $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        if ($constraint->ignoreEmptyString) {
            return null !== $constraintTypeControl->getValue();
        }

        return !empty($constraintTypeControl->getValue());
    }
}