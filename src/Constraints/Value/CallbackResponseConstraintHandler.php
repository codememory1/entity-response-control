<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use function is_array;
use RuntimeException;

final class CallbackResponseConstraintHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param CallbackResponseConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): array
    {
        $namespaceResponseData = $constraint->namespaceResponseData;

        if (false === class_exists($namespaceResponseData)) {
            throw new RuntimeException("Class ResponseControl: {$namespaceResponseData} not exist");
        }

        if (!is_array($constraintTypeControl->getValue())) {
            return [];
        }

        $responseData = new $namespaceResponseData((new $constraint->disassembler())());

        $responseData
            ->setData($constraintTypeControl->getValue())
            ->getObjectDisassembler()
            ->setIgnoreDataProperties($constraint->ignoreProperties)
            ->setIgnoreAllDataPropertiesExcept($constraint->onlyProperties);

        return $responseData->collect()->toArray();
    }
}