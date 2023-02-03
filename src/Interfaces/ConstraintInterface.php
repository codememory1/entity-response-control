<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ConstraintInterface
{
    /**
     * Should return the namespace of the handler that implements the interface: Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface.
     */
    public function getHandler(): string;
}