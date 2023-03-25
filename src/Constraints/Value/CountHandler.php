<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use Countable;
use function is_array;
use function is_string;

final class CountHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param Count $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        if (is_array($constraintTypeControl->getValue())) {
            return count($constraintTypeControl->getValue());
        }

        if ($constraintTypeControl->getValue() instanceof Countable) {
            return $constraintTypeControl->getValue()->count();
        }

        if (is_string($constraintTypeControl->getValue())) {
            return mb_strlen($constraintTypeControl->getValue());
        }

        return (int) $constraintTypeControl->getValue();
    }
}