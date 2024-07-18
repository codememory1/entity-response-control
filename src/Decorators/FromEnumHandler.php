<?php

namespace Codememory\EntityResponseControl\Decorators;

use BackedEnum;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use LogicException;
use UnitEnum;

final class FromEnumHandler implements DecoratorHandlerInterface
{
    /**
     * @param FromEnum $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $currentValue = $context->getValue();
        $newValue = $context->getProperty()->getDefaultValue();

        if (!in_array($decorator->format, FromEnum::FORMATS, true)) {
            $this->throwIfInvalidFormat($context, $decorator->format);
        }

        if (!empty($currentValue)) {
            $newValue = match ($decorator->format) {
                FromEnum::KEY_LABEL_FORMAT => $this->keyLabelFormat($context, $currentValue),
                FromEnum::ONLY_KEY_FORMAT => $this->onlyKeyFormat($context, $currentValue),
                FromEnum::ONLY_LABEL_FORMAT => $this->onlyLabelFormat($context, $currentValue),
            };
        }

        $context->setValue($newValue);
    }

    private function keyLabelFormat(ExecutionContextInterface $context, mixed $enum): array
    {
        $this->throwIfNotUnitEnum($context, $enum);
        $this->throwIfNotBackedEnum($context, $enum);

        return [
            'key' => $enum->name,
            'label' => $enum->value
        ];
    }

    private function onlyKeyFormat(ExecutionContextInterface $context, mixed $enum): string
    {
        $this->throwIfNotUnitEnum($context, $enum);

        return $enum->name;
    }

    private function onlyLabelFormat(ExecutionContextInterface $context, mixed $enum): int|string
    {
        $this->throwIfNotBackedEnum($context, $enum);

        return $enum->value;
    }

    private function throwIfInvalidFormat(ExecutionContextInterface $context, string $format): void
    {
        $prototypeClass = $context->getResponsePrototype()::class;

        if (!in_array($format, FromEnum::FORMATS, true)) {
            throw new LogicException("Incorrect enum output format in the \"{$prototypeClass}\" prototype in the \"{$context->getProperty()->getName()}\" property");
        }
    }

    private function throwIfNotUnitEnum(ExecutionContextInterface $context, mixed $enum): void
    {
        $prototypeClass = $context->getResponsePrototype()::class;

        if (!$enum instanceof UnitEnum) {
            throw new LogicException("The value that goes into the \"{$context->getProperty()->getName()}\" property of the \"{$prototypeClass}\" ResponseControl must implement \UnitEnum");
        }
    }

    private function throwIfNotBackedEnum(ExecutionContextInterface $context, mixed $enum): void
    {
        $prototypeClass = $context->getResponsePrototype()::class;

        if (!$enum instanceof BackedEnum) {
            throw new LogicException("The value that goes into the \"{$context->getProperty()->getName()}\" property of the \"{$prototypeClass}\" ResponseControl must implement \BackedEnum");
        }
    }
}