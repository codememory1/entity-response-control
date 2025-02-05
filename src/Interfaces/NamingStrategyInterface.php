<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface NamingStrategyInterface
{
    public function propertyNameToCollectedKey(string $propertyName): string;
}