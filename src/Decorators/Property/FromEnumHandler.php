<?php

namespace Codememory\EntityResponseControl\Decorators\Property;

use BackedEnum;
use Codememory\EntityResponseControl\Exceptions\ResponsePrototypeException;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextInterface;
use function is_array;
use UnitEnum;

class FromEnumHandler implements PropertyDecoratorHandlerInterface
{
    /**
     * @param FromEnum $decorator
     *
     * @throws ResponsePrototypeException
     */
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void
    {
        $newValue = $executionContext->getPropertyWrapper()->getPropertyReflector()->getDefaultValue();

        if (!in_array($decorator->format, FromEnum::FORMATS, true)) {
            $this->throwIfInvalidFormat($executionContext, $decorator->format);
        }

        if ($decorator->multiple) {
            if (is_array($executionContext->getValue())) {
                $newValue = [];

                foreach ($executionContext->getValue() as $case) {
                    $newValue[] = $this->formatValue($decorator, $executionContext, $case);
                }
            }
        } else {
            if (!empty($executionContext->getValue())) {
                $newValue = $this->formatValue($decorator, $executionContext, $executionContext->getValue());
            }
        }

        $executionContext->setValue($newValue);
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function formatValue(FromEnum $decorator, PropertyExecutionContextInterface $context, mixed $value): mixed
    {
        return match ($decorator->format) {
            FromEnum::KEY_LABEL_FORMAT => $this->keyLabelFormat($context, $value),
            FromEnum::ONLY_KEY_FORMAT => $this->onlyKeyFormat($context, $value),
            FromEnum::ONLY_LABEL_FORMAT => $this->onlyLabelFormat($context, $value),
        };
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function keyLabelFormat(PropertyExecutionContextInterface $context, mixed $enum): array
    {
        $this->throwIfNotUnitEnum($context, $enum);
        $this->throwIfNotBackedEnum($context, $enum);

        return [
            'key' => $enum->name,
            'label' => $enum->value
        ];
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function onlyKeyFormat(PropertyExecutionContextInterface $context, mixed $enum): string
    {
        $this->throwIfNotUnitEnum($context, $enum);

        return $enum->name;
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function onlyLabelFormat(PropertyExecutionContextInterface $context, mixed $enum): int|string
    {
        $this->throwIfNotBackedEnum($context, $enum);

        return $enum->value;
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function throwIfInvalidFormat(PropertyExecutionContextInterface $executionContext, string $format): void
    {
        if (!in_array($format, FromEnum::FORMATS, true)) {
            throw new ResponsePrototypeException($executionContext->getPrototypeExecutionContext()->getClassReflector()->getName(), "Incorrect enum output format in the \"{$executionContext->getPropertyWrapper()->getName()}\" property.");
        }
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function throwIfNotUnitEnum(PropertyExecutionContextInterface $executionContext, mixed $enum): void
    {
        if (!$enum instanceof UnitEnum) {
            throw new ResponsePrototypeException($executionContext->getPrototypeExecutionContext()->getClassReflector()->getName(), "The value that goes into the \"{$executionContext->getPropertyWrapper()->getName()}\" property must be implemented by \UnitEnum");
        }
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function throwIfNotBackedEnum(PropertyExecutionContextInterface $executionContext, mixed $enum): void
    {
        if (!$enum instanceof BackedEnum) {
            throw new ResponsePrototypeException($executionContext->getPrototypeExecutionContext()->getClassReflector()->getName(), "The value that goes into the \"{$executionContext->getPropertyWrapper()->getName()}\" property must be implemented by \BackedEnum");
        }
    }
}