<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Interfaces\CollectorInterface;
use Codememory\EntityResponseControl\Interfaces\ConfigurationFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\ConfigurationInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeInterface;
use Codememory\Reflection\ReflectorManager;
use Codememory\Reflection\Reflectors\ClassReflector;
use function is_array;
use function is_object;
use IteratorAggregate;
use Psr\Cache\InvalidArgumentException;
use ReflectionException;

abstract class AbstractResponsePrototype implements ResponsePrototypeInterface
{
    protected readonly ClassReflector $_classReflector;
    protected readonly ConfigurationInterface $_configuration;
    protected bool $_outputAsOne = false;
    protected array $_dataObjects = [];
    protected array $_collectedResponse = [];

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected readonly CollectorInterface $_collector,
        protected readonly ConfigurationFactoryInterface $_configurationFactory,
        protected readonly ExecutionContextFactoryInterface $_executionContextFactory,
        protected readonly ReflectorManager $_reflectorManager
    ) {
        $this->_classReflector = $this->_reflectorManager->getReflector(static::class);
        $this->_configuration = $this->_configurationFactory->createConfiguration();
    }

    public function getCollector(): CollectorInterface
    {
        return $this->_collector;
    }

    public function getConfigurationFactory(): ConfigurationFactoryInterface
    {
        return $this->_configurationFactory;
    }

    public function getConfiguration(): ConfigurationInterface
    {
        return $this->_configuration;
    }

    public function getExecutionContextFactory(): ExecutionContextFactoryInterface
    {
        return $this->_executionContextFactory;
    }

    public function getReflectorManager(): ReflectorManager
    {
        return $this->_reflectorManager;
    }

    public function getClassReflector(): ClassReflector
    {
        return $this->_classReflector;
    }

    public function collect(object|array $data): ResponsePrototypeInterface
    {
        $this->setupData($data);

        $properties = $this->_configuration->getResponsePrototypePropertyProvider()->getProperties($this->getClassReflector());

        foreach ($this->_dataObjects as $dataObject) {
            $this->_collectedResponse[] = $this->getCollector()->collect($this, $dataObject, $properties);
        }

        return $this;
    }

    public function toArray(): array
    {
        if ($this->_outputAsOne) {
            return $this->_collectedResponse[array_key_first($this->_collectedResponse)];
        }

        return $this->_collectedResponse;
    }

    private function setupData(object|array $data): void
    {
        if ($data instanceof IteratorAggregate || is_array($data)) {
            $this->_dataObjects = array_filter($data, static fn (mixed $value) => is_object($value));
            $this->_outputAsOne = false;
        } else {
            $this->_dataObjects = [$data];
            $this->_outputAsOne = true;
        }
    }
}