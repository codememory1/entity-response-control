<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface DecoratorHandlerRegistrarInterface
{
    public function register(DecoratorHandlerInterface $handler): self;

    public function getHandlers(): array;

    public function getHandler(string $namespace): DecoratorHandlerInterface;
}