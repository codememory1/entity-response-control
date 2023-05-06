<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use DateTimeInterface;

final class DateTimeHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param DateTime $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        $value = $constraintTypeControl->getValue();

        if ($value instanceof DateTimeInterface || null === $value) {
            if (!$constraint->full) {
                return $value?->format($constraint->format);
            }

            return null === $value ? null : $this->toArray($value);
        }

        return null;
    }

    private function toArray(DateTimeInterface $dateTime): array
    {
        $timezone = $dateTime->getTimezone();

        return [
            'date' => [
                'year' => $dateTime->format('Y'),
                'month' => $dateTime->format('m'),
                'day' => $dateTime->format('d')
            ],
            'time' => [
                'hours' => $dateTime->format('H'),
                'minutes' => $dateTime->format('i'),
                'seconds' => $dateTime->format('s')
            ],
            'timestamp' => $dateTime->getTimestamp(),
            'timezone' => false !== $timezone ? $timezone->getName() : null
        ];
    }
}