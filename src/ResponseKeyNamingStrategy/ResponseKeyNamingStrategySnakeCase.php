<?php

namespace Codememory\EntityResponseControl\ResponseKeyNamingStrategy;

use function call_user_func;
use Closure;
use Codememory\EntityResponseControl\Interfaces\ResponseKeyNamingStrategyInterface;
use function Symfony\Component\String\u;

final class ResponseKeyNamingStrategySnakeCase implements ResponseKeyNamingStrategyInterface
{
    private ?Closure $extension = null;

    public function convert(string $propertyName): string
    {
        $name = u($propertyName)->snake();

        if (null !== $this->extension) {
            $name = call_user_func($this->extension, $name);
        }

        return $name;
    }

    public function setExtension(callable $callback): ResponseKeyNamingStrategyInterface
    {
        $this->extension = $callback;

        return $this;
    }
}