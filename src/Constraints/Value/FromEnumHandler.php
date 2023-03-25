<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use function constant;
use function defined;

final class FromEnumHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param FromEnum $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): ?array
    {
        $value = $constraintTypeControl->getValue();

        if (empty($value)) {
            return null;
        }

        $pathToCase = "{$constraint->enum}::{$value}";

        return !defined($pathToCase) ? null : ['key' => $value, 'label' => constant($pathToCase)->value];
    }
}