<?php

namespace Codememory\EntityResponseControl\Decorators;

use function call_user_func;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use DateTimeInterface;
use function is_array;
use LogicException;

final class DateTimeHandler implements DecoratorHandlerInterface
{
    /**
     * @param DateTime $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        if (!in_array($decorator->format, DateTime::FORMATS, true)) {
            $this->throwIfInvalidFormat($context, $decorator->format);
        }

        $dateTime = $context->getValue();
        $options = array_replace_recursive(DateTime::DEFAULT_FORMAT_OPTIONS[$decorator->format], $decorator->options);

        $context->setValue($dateTime instanceof DateTimeInterface ? match ($decorator->format) {
            DateTime::STRING_FORMAT => $this->stringFormat($dateTime, $options),
            DateTime::FULL_FORMAT => $this->fullFormat($dateTime, $options),
            DateTime::TIMESTAMP_FORMAT => $this->timestampFormat($dateTime, $options)
        } : $context->getProperty()->getDefaultValue());
    }

    private function stringFormat(DateTimeInterface $dateTime, array $options): string
    {
        return $dateTime->format($options['format']);
    }

    private function fullFormat(DateTimeInterface $dateTime, array $options): array
    {
        $value = [];

        if (is_array($options['callback']) && count($options['callback']) >= 2) {
            $value = call_user_func($options['callback'], $dateTime, $options);
        } else {
            if ($options['date']['enabled']) {
                $value['date'] = [];

                if (is_array($options['date']['callback']) && count($options['date']['callback']) >= 2) {
                    $value['date'] = call_user_func($options['date']['callback'], $dateTime, $options['date']);
                } else {
                    if ($options['date']['year']['enabled']) {
                        $value['date']['year'] = $dateTime->format($options['date']['year']['format']);
                    }

                    if ($options['date']['month']['enabled']) {
                        $value['date']['month'] = $dateTime->format($options['date']['month']['format']);
                    }

                    if ($options['date']['week']['enabled']) {
                        $value['date']['week'] = $dateTime->format($options['date']['week']['format']);
                    }

                    if ($options['date']['day']['enabled']) {
                        $value['date']['day'] = $dateTime->format($options['date']['day']['format']);
                    }

                    if ($options['date']['show_leap_year']) {
                        $value['date']['leap_year'] = '1' === $dateTime->format('L');
                    }
                }
            }

            if ($options['time']['enabled']) {
                $value['time'] = [];

                if (is_array($options['time']['callback']) && count($options['time']['callback']) >= 2) {
                    $value['time'] = call_user_func($options['time']['callback'], $dateTime, $options['time']);
                } else {
                    if ($options['time']['hours']['enabled']) {
                        $value['time']['hours'] = $dateTime->format($options['time']['hours']['format']);
                    }

                    if ($options['time']['minutes']['enabled']) {
                        $value['time']['minutes'] = $dateTime->format($options['time']['minutes']['format']);
                    }

                    if ($options['time']['seconds']['enabled']) {
                        $value['time']['seconds'] = $dateTime->format($options['time']['seconds']['format']);
                    }
                }
            }

            if ($options['timestamp']['enabled']) {
                $value['timestamp'] = $dateTime->getTimestamp();

                if (is_array($options['timestamp']['callback']) && count($options['timestamp']['callback']) >= 2) {
                    $value['timestamp'] = call_user_func($options['timestamp']['callback'], $dateTime, $options['timestamp']);
                }
            }

            if ($options['timezone']['enabled']) {
                $value['timezone'] = false !== $dateTime->getTimezone() ? $dateTime->getTimezone()->getName() : null;

                if (is_array($options['timezone']['callback']) && count($options['timezone']['callback']) >= 2) {
                    $value['timezone'] = call_user_func($options['timezone']['callback'], $dateTime, $options['timezone']);
                }
            }
        }

        return $value;
    }

    private function timestampFormat(DateTimeInterface $dateTime, array $options): int
    {
        return $dateTime->getTimestamp();
    }

    private function throwIfInvalidFormat(ExecutionContextInterface $context, string $format): void
    {
        $prototypeClass = $context->getResponsePrototype()::class;

        if (!in_array($format, FromEnum::FORMATS, true)) {
            throw new LogicException("Incorrect DateTime output format in the \"{$prototypeClass}\" prototype in the \"{$context->getProperty()->getName()}\" property");
        }
    }
}