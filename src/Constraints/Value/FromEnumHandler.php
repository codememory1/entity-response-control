<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use BackedEnum;
use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use LogicException;
use UnitEnum;
use function constant;
use function defined;

final class FromEnumHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param FromEnum $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): ?array
    {
        $responseControlNamespace = $constraintTypeControl->responseControl::class;
        $value = $constraintTypeControl->getValue();

        if (empty($value)) {
            return null;
        }

        if (null === $constraint->enum) {
            if (!$value instanceof UnitEnum) {
                throw new LogicException("The value that goes into the {$constraintTypeControl->property->getName()} property of the $responseControlNamespace ResponseControl must implement \UnitEnum");
            }

            if (!$value instanceof BackedEnum) {
                throw new LogicException("The value that goes into the {$constraintTypeControl->property->getName()} property of the $responseControlNamespace ResponseControl must implement \BackedEnum");
            }

            return $this->buildValue($value->name, $value->value);
        }

        $pathToCase = "{$constraint->enum}::{$value}";

        return !defined($pathToCase) ? null : $this->buildValue($value, constant($pathToCase)->value);
    }

    private function buildValue(string $key, string|int $label): array
    {
        return [
            'key' => $key,
            'label' => $label
        ];
    }
}