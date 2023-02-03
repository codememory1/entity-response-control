<?php

namespace Codememory\EntityResponseControl\Adapters;

use function is_object;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class ReflectionAdapter
{
    private readonly string $namespaceClass;
    private readonly ReflectionClass $reflection;

    /**
     * @throws ReflectionException
     */
    public function __construct(string|object $class)
    {
        $this->namespaceClass = is_object($class) ? $class::class : $class;
        $this->reflection = new ReflectionClass($class);
    }

    /**
     * @return array<int, ReflectionProperty>
     */
    public function getControlledProperties(array $ignoreProperties = [], array $onlyProperties = []): array
    {
        $namespaceClass = $this->namespaceClass;

        return array_filter(
            $this->reflection->getProperties(ReflectionProperty::IS_PRIVATE),
            static function(ReflectionProperty $property) use ($namespaceClass, $ignoreProperties, $onlyProperties) {
                $notIgnored = !in_array($property->getName(), $ignoreProperties, true);
                $notIgnoredWithRespectToOnly = [] === $onlyProperties || in_array($property->getName(), $onlyProperties, true);

                return $property->class === $namespaceClass && $notIgnored && $notIgnoredWithRespectToOnly;
            }
        );
    }

    /**
     * @param array<int, ReflectionProperty> $properties
     */
    public function getProperty(array $properties, string $name): ?ReflectionProperty
    {
        foreach ($properties as $property) {
            if ($property->getName() === $name) {
                return $property;
            }
        }

        return null;
    }
}