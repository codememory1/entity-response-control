<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Interfaces\ConfigurationInterface;
use Codememory\EntityResponseControl\Interfaces\ResponseKeyNamingStrategyInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypePropertyProviderInterface;
use Codememory\EntityResponseControl\Provider\ResponsePrototypePrivatePropertyProvider;
use Codememory\EntityResponseControl\ResponseKeyNamingStrategy\ResponseKeyNamingStrategySnakeCase;

final class Configuration implements ConfigurationInterface
{
    private ?ResponseKeyNamingStrategyInterface $responseKeyNamingStrategy = null;
    private ?ResponsePrototypePropertyProviderInterface $responsePrototypePropertyProvider = null;

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
}