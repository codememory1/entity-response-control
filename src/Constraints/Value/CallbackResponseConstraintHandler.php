<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Exception\ResponseControlNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use function is_array;

final class CallbackResponseConstraintHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param CallbackResponseConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): array
    {
        $namespaceResponseControl = $constraint->namespaceResponseData;

        if (false === class_exists($namespaceResponseControl)) {
            throw new ResponseControlNotFoundException($namespaceResponseControl);
        }

        if (!is_array($constraintTypeControl->getValue()) && !is_object($constraintTypeControl->getValue())) {
            return [];
        }

        $disassembler = new ($constraint->disassembler)();
        $responseControl = new $namespaceResponseControl($disassembler);

        $responseControl
            ->setData($constraintTypeControl->getValue())
            ->getObjectDisassembler()
            ->setIgnoreDataProperties($constraint->ignoreProperties)
            ->setIgnoreAllDataPropertiesExcept($constraint->onlyProperties);

        return $responseControl->collect()->toArray();
    }
}