<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Exception\MethodNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;
use function Symfony\Component\String\u;

final class PrefixConstraintHandler implements SystemConstraintHandlerInterface
{
    /**
     * @param PrefixConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        if (null !== $constraint->method) {
            $constraintTypeControl->setPrefixMethod($constraint->method);

            if (!method_exists($constraintTypeControl->object, $constraintTypeControl->getMethodName())) {
                throw new MethodNotFoundException($constraintTypeControl->object, $constraintTypeControl->getMethodName());
            }

            $constraintTypeControl->setValue($constraintTypeControl->object->{$constraintTypeControl->getMethodName()}());
        }

        if (null !== $constraint->response) {
            $propertyName = $constraintTypeControl->property->getName();

            $constraintTypeControl->setPropertyNameInResponse(u("{$constraint->response}_{$propertyName}")->snake()->toString());
        }

        return true;
    }
}