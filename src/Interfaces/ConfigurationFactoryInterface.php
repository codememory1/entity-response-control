<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ConfigurationFactoryInterface
{
    public function createConfiguration(): ConfigurationInterface;
}