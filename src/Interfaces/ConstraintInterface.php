<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ConstraintInterface
{
    /**
     * Constraint type, example: Codememory\EntityResponseControl\ConstraintTypeHandlers\AvailabilityConstraintHandler,...
     */
    public function getType(): string;

    /**
     * Should return the namespace of the handler that implements the interface: Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface.
     */
    public function getHandler(): string;
}