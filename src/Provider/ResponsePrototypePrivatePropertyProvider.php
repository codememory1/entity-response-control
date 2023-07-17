<?php

namespace Codememory\EntityResponseControl\Provider;

use function call_user_func;
use Closure;
use Codememory\EntityResponseControl\AbstractResponsePrototype;
use Codememory\EntityResponseControl\Interfaces\ResponsePrototypePropertyProviderInterface;
use Codememory\Reflection\Reflectors\ClassReflector;
use function is_array;
use LogicException;
use ReflectionProperty;

final class ResponsePrototypePrivatePropertyProvider implements ResponsePrototypePropertyProviderInterface
{
    private ?Closure $extension = null;

    public function getProperties(ClassReflector $classReflector): array
    {
        $properties = $classReflector->getPropertiesIncludingParent([AbstractResponsePrototype::class], ReflectionProperty::IS_PRIVATE);

        if (null !== $this->extension) {
            $properties = call_user_func($this->extension, $properties);

            if (!is_array($properties)) {
                throw new LogicException('ResponsePrototypePrivatePropertyProvider provider extension callback must return an array of properties');
            }
        }

        return $properties;
    }

    public function setExtension(callable $callback): ResponsePrototypePropertyProviderInterface
    {
        $this->extension = $callback;

        return $this;
    }
}