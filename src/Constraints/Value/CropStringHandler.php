<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;

final class CropStringHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param CropString $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): ?string
    {
        $value = $constraintTypeControl->getValue();

        if (!empty($value)) {
            $length = mb_strlen($value, 'UTF-8');

            if ($length > $constraint->maxlength) {
                return trim(mb_substr($value, 0, $constraint->maxlength)) . $constraint->end;
            }
        }

        return $value;
    }
}