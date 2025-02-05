<?php

namespace Codememory\EntityResponseControl\NamingStrategy;

use Codememory\EntityResponseControl\Interfaces\NamingStrategyInterface;
use function Symfony\Component\String\u;

class SnakeCamelNamingStrategy implements NamingStrategyInterface
{
    public function propertyNameToCollectedKey(string $propertyName): string
    {
        return u($propertyName)->snake()->toString();
    }
}