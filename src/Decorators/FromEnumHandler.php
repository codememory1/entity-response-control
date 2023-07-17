<?php

namespace Codememory\EntityResponseControl\Decorators;

use BackedEnum;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use function constant;
use function defined;
use LogicException;
use UnitEnum;

final class FromEnumHandler implements DecoratorHandlerInterface
{
    /**
     * @param FromEnum $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $prototypeNamespace = $context->getResponsePrototype()::class;
        $value = $context->getValue();

        if (empty($value)) {
            $context->setValue($context->getProperty()->getDefaultValue());
        }

        if (null === $decorator->enum) {
            if (!$value instanceof UnitEnum) {
                throw new LogicException("The value that goes into the {$context->getProperty()->getName()} property of the {$prototypeNamespace} ResponseControl must implement \UnitEnum");
            }

            if (!$value instanceof BackedEnum) {
                throw new LogicException("The value that goes into the {$context->getProperty()->getName()} property of the {$prototypeNamespace} ResponseControl must implement \BackedEnum");
            }

            $context->setValue($this->buildValue($value->name, $value->value));
        } else {
            $pathToCase = "{$decorator->enum}::{$value}";

            if (!defined($pathToCase)) {
                $context->setValue($context->getProperty()->getDefaultValue());
            } else {
                $context->setValue($this->buildValue($value, constant($pathToCase)->value));
            }
        }
    }

    private function buildValue(string $key, string|int $label): array
    {
        return [
            'key' => $key,
            'label' => $label
        ];
    }
}