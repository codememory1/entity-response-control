<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Interfaces\CollectorInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorRegistrarInterface;
use Codememory\EntityResponseControl\Interfaces\PropertyExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypeManagerInterface;
use Codememory\Reflection\ReflectorManager;
use Codememory\Reflection\Reflectors\AttributeReflector;
use Exception;
use function is_array;
use IteratorAggregate;
use Psr\Cache\InvalidArgumentException;
use ReflectionException;

readonly class ResponsePrototypeManager implements ResponsePrototypeManagerInterface
{
    public function __construct(
        private ReflectorManager $reflectorManager,
        private PrototypeExecutionContextFactoryInterface $prototypeExecutionContextFactory,
        private PropertyExecutionContextFactoryInterface $propertyExecutionContextFactory,
        private CollectorInterface $collector,
        private DecoratorRegistrarInterface $decoratorRegistrar
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws Exception
     */
    public function collect(string $prototypeClassName, array|object $data, array $decorators = [], array $metadata = []): array
    {
        $reflector = $this->reflectorManager->getReflector($prototypeClassName);
        $prototypeExecutionContext = $this->prototypeExecutionContextFactory->create($this, $reflector, $data, $metadata);
        $propertyExecutionContext = $this->propertyExecutionContextFactory->create($prototypeExecutionContext);
        $isMultidimensionalData = $this->isMultidimensionalData($data);
        $collected = [];

        foreach ([...$reflector->getAttributes(), ...$decorators] as $attribute) {
            $attributeInstance = $attribute instanceof AttributeReflector ? $attribute->getInstance() : $attribute;

            if ($attributeInstance instanceof PrototypeDecoratorInterface) {
                $this->decoratorRegistrar->getHandler($attributeInstance->getHandler())->process($attributeInstance, $prototypeExecutionContext);
            }
        }

        foreach ($this->formatData($data) as $object) {
            $collected[] = $this->collector->collect($propertyExecutionContext, $object);
        }

        if (!$isMultidimensionalData && count($collected) > 0) {
            return $collected[0];
        }

        return $collected;
    }

    /**
     * @throws Exception
     */
    private function formatData(array|object $data): array
    {
        if ($data instanceof IteratorAggregate) {
            return iterator_to_array($data->getIterator());
        }

        if (is_array($data)) {
            return $data;
        }

        return [$data];
    }

    private function isMultidimensionalData(array|object $data): bool
    {
        return (bool) ($data instanceof IteratorAggregate || is_array($data));
    }
}