<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface PropertyDecoratorHandlerInterface extends DecoratorHandlerInterface
{
    public function process(PropertyDecoratorInterface $decorator, PropertyExecutionContextInterface $executionContext): void;
}