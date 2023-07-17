<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface DecoratorHandlerInterface
{
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void;
}