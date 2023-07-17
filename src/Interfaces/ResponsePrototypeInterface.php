<?php

namespace Codememory\EntityResponseControl\Interfaces;

use Codememory\Reflection\ReflectorManager;
use Codememory\Reflection\Reflectors\ClassReflector;

interface ResponsePrototypeInterface
{
    public function getCollector(): CollectorInterface;

    public function getConfigurationFactory(): ConfigurationFactoryInterface;

    public function getConfiguration(): ConfigurationInterface;

    public function getExecutionContextFactory(): ExecutionContextFactoryInterface;

    public function getReflectorManager(): ReflectorManager;

    public function getClassReflector(): ClassReflector;

    /**
     * @param array<int, object>|object $data
     */
    public function collect(object|array $data): self;

    public function toArray(): array;
}