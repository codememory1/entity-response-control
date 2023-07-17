<?php

namespace Codememory\EntityResponseControl\Factory;

use Codememory\EntityResponseControl\Configuration;
use Codememory\EntityResponseControl\Interfaces\ConfigurationFactoryInterface;
use Codememory\EntityResponseControl\Interfaces\ConfigurationInterface;

final class ConfigurationFactory implements ConfigurationFactoryInterface
{
    public function createConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }
}