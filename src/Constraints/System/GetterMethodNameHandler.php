<?php

namespace Codememory\EntityResponseControl\Constraints\System;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\SystemConstraintHandlerInterface;

final class GetterMethodNameHandler implements SystemConstraintHandlerInterface
{
    private const RESERVED_KEYS = [
        '{name}' // Capitalized property name
    ];

    /**
     * @param GetterMethodName $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): bool
    {
        $name = str_replace(self::RESERVED_KEYS, [
            ucfirst($constraintTypeControl->property->getName())
        ], $constraint->name);

        $constraintTypeControl
            ->setMethodName($name)
            ->setValue($constraintTypeControl->object->{$constraintTypeControl->getMethodName()}());

        return true;
    }
}