<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Exception\DecoratorHandlerNotRegisteredException;
use Codememory\EntityResponseControl\Interfaces\ConfigurationInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\ResponseKeyNamingStrategyInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypePropertyProviderInterface;
use Codememory\EntityResponseControl\Provider\ResponsePrototypePrivatePropertyProvider;
use Codememory\EntityResponseControl\ResponseKeyNamingStrategy\ResponseKeyNamingStrategySnakeCase;

final class Configuration implements ConfigurationInterface
{
    private ?ResponseKeyNamingStrategyInterface $responseKeyNamingStrategy = null;
    private ?ResponsePrototypePropertyProviderInterface $responsePrototypePropertyProvider = null;
    private array $decoratorHandlers = [];

    public function __construct()
    {
        $this->decoratorHandlersRegistrationWrapper();
    }

    public function getResponseKeyNamingStrategy(): ResponseKeyNamingStrategyInterface
    {
        return $this->responseKeyNamingStrategy ?: $this->responseKeyNamingStrategy = new ResponseKeyNamingStrategySnakeCase();
    }

    public function setResponseKeyNamingStrategy(ResponseKeyNamingStrategyInterface $strategy): ConfigurationInterface
    {
        $this->responseKeyNamingStrategy = $strategy;

        return $this;
    }

    public function getResponsePrototypePropertyProvider(): ResponsePrototypePropertyProviderInterface
    {
        return $this->responsePrototypePropertyProvider ?: $this->responsePrototypePropertyProvider = new ResponsePrototypePrivatePropertyProvider();
    }

    public function setResponsePrototypePropertyProvider(ResponsePrototypePropertyProviderInterface $provider): ConfigurationInterface
    {
        $this->responsePrototypePropertyProvider = $provider;

        return $this;
    }

    public function getDecoratorHandlers(): array
    {
        return $this->decoratorHandlers;
    }

    /**
     * @throws DecoratorHandlerNotRegisteredException
     */
    public function getDecoratorHandler(string $handlerNamespace): DecoratorHandlerInterface
    {
        return $this->decoratorHandlers[$handlerNamespace] ?? throw new DecoratorHandlerNotRegisteredException($handlerNamespace);
    }

    public function registerDecoratorHandler(DecoratorHandlerInterface $handler): ConfigurationInterface
    {
        if (!array_key_exists($handler::class, $this->decoratorHandlers)) {
            $this->decoratorHandlers[$handler::class] = $handler;
        }

        return $this;
    }

    private function decoratorHandlersRegistrationWrapper(): void
    {
        $this->registerDecoratorHandler(new Decorators\NestedPrototypeHandler());
        $this->registerDecoratorHandler(new Decorators\CountHandler());
        $this->registerDecoratorHandler(new Decorators\BoolTransformerHandler());
        $this->registerDecoratorHandler(new Decorators\FromEnumHandler());
        $this->registerDecoratorHandler(new Decorators\DateTimeHandler());
        $this->registerDecoratorHandler(new Decorators\CropStringHandler());
        $this->registerDecoratorHandler(new Decorators\MaxElementsHandler());
        $this->registerDecoratorHandler(new Decorators\CallbackHandler());
        $this->registerDecoratorHandler(new Decorators\ArrayValuesHandler());
        $this->registerDecoratorHandler(new Decorators\XSSHandler());
        $this->registerDecoratorHandler(new Decorators\AliasInResponseHandler());
        $this->registerDecoratorHandler(new Decorators\CustomHandler());
        $this->registerDecoratorHandler(new Decorators\PrefixHandler());
        $this->registerDecoratorHandler(new Decorators\PrototypeObjectGetterMethodHandler());
        $this->registerDecoratorHandler(new Decorators\HiddenNullableHandler());
    }
}