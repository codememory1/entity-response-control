<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use function is_array;
use function is_object;

final class ArrayValuesHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param ArrayValues $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): array
    {
        $values = [];

        foreach ($constraintTypeControl->getValue() as $item) {
            if (is_object($item) && method_exists($item, $constraint->key)) {
                $values[] = $item->{$constraint->key}();
            } else if (is_array($item) && array_key_exists($constraint->key, $item)) {
                $values[] = $item[$constraint->key];
            }
        }

        return $values;
    }
}