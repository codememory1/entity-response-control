<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;

final class MaxElementsHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param MaxElements $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): ?array
    {
        $value = $constraintTypeControl->getValue();

        return empty($value) ? [] : array_splice($value, 0, $constraint->max);
    }
}