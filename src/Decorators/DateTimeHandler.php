<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use DateTimeInterface;

final class DateTimeHandler implements DecoratorHandlerInterface
{
    /**
     * @param DateTime $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $value = $context->getValue();
        $defaultValue = $context->getProperty()->getDefaultValue();

        if ($value instanceof DateTimeInterface) {
            $context->setValue($decorator->full ? $this->toArray($value) : $value->format($decorator->format));
        } else {
            $context->setValue($defaultValue);
        }
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