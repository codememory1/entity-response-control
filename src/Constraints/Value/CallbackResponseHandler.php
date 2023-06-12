<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Exception\ResponseControlNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use function is_array;
use function is_object;

final class CallbackResponseHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param CallbackResponse $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        $value = $constraintTypeControl->getValue();
        $namespaceResponseControl = $constraint->namespaceResponseData;

        if (false === class_exists($namespaceResponseControl)) {
            throw new ResponseControlNotFoundException($namespaceResponseControl);
        }

        if (!is_array($value) && !is_object($value)) {
            return $constraintTypeControl->property->getDefaultValue();
        }

        $disassembler = new ($constraint->disassembler)();
        $responseControl = new $namespaceResponseControl(
            $disassembler,
            $constraintTypeControl->responseControl->getReflectorManager(),
            $constraintTypeControl->responseControl->getConstraintTypeHandlerRegister(),
            $constraintTypeControl->responseControl->getConstraintHandlerRegister()
        );

        $responseControl
            ->setData($value)
            ->getObjectDisassembler()
            ->setIgnoreDataProperties($constraint->ignoreProperties)
            ->setIgnoreAllDataPropertiesExcept($constraint->onlyProperties);

        return $responseControl->collect()->toArray();
    }
}