<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ConfigurationInterface
{
    public function getResponseKeyNamingStrategy(): ResponseKeyNamingStrategyInterface;

    public function setResponseKeyNamingStrategy(ResponseKeyNamingStrategyInterface $strategy): self;

    public function getResponsePrototypePropertyProvider(): ResponsePrototypePropertyProviderInterface;

    public function setResponsePrototypePropertyProvider(ResponsePrototypePropertyProviderInterface $provider): self;
}