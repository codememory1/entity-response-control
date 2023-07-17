<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ResponseKeyNamingStrategyInterface
{
    public function convert(string $propertyName): string;

    /**
     * @param callable(string $name): string $callback
     *
     * The callback must fire before the return value in the convert method, callback takes an argument value of convert and must return a value with the return type of the convert method
     */
    public function setExtension(callable $callback): self;
}