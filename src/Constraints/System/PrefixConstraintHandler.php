<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;
use LogicException;
use function Symfony\Component\String\u;

final class PrefixConstraintHandler implements SystemConstraintHandlerInterface
{
    /**
     * @param PrefixConstraint $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        if (null !== $constraint->method) {
            if (!method_exists($constraintTypeControl->object, $constraint->method)) {
                $objectNamespace = $constraintTypeControl->object::class;

                throw new LogicException("Method {$constraint->method} not found to ResponseControl: {$objectNamespace}");
            }

            $constraintTypeControl->setPrefixMethod($constraint->method);
            $constraintTypeControl->setValue($constraintTypeControl->object->{$constraint->method}());
        }

        if (null !== $constraint->response) {
            $propertyName = $constraintTypeControl->property->getName();

            $constraintTypeControl->setPropertyNameInResponse(u("{$constraint->response}_{$propertyName}")->snake()->toString());
        }

        return true;
    }
}