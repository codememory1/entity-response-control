<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface PrototypeDecoratorHandlerInterface extends DecoratorHandlerInterface
{
    public function process(PrototypeDecoratorInterface $decorator, PrototypeExecutionContextInterface $executionContext): void;
}