<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\EntityResponseControl\Exception\DecoratorHandlerNotRegisteredException;

interface ConfigurationInterface
{
    public function getResponseKeyNamingStrategy(): ResponseKeyNamingStrategyInterface;

    public function setResponseKeyNamingStrategy(ResponseKeyNamingStrategyInterface $strategy): self;

    public function getResponsePrototypePropertyProvider(): ResponsePrototypePropertyProviderInterface;

    public function setResponsePrototypePropertyProvider(ResponsePrototypePropertyProviderInterface $provider): self;

    /**
     * @return array<int, DecoratorHandlerInterface>
     */
    public function getDecoratorHandlers(): array;

    /**
     * @throws DecoratorHandlerNotRegisteredException
     */
    public function getDecoratorHandler(string $handlerNamespace): DecoratorHandlerInterface;

    public function registerDecoratorHandler(DecoratorHandlerInterface $handler): self;
}