<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface DecoratorRegistrarInterface
{
    public function registerHandler(DecoratorHandlerInterface $handler): static;

    public function getHandler(string $className): ?DecoratorHandlerInterface;

    public function existsHandler(string $className): bool;

    /**
     * @return array<int, DecoratorHandlerInterface>
     */
    public function getAllHandler(): array;
}