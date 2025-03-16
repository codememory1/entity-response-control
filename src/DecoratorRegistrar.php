<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Decorators\Property;
use Codememory\EntityResponseControl\Decorators\Prototype;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorRegistrarInterface;

class DecoratorRegistrar implements DecoratorRegistrarInterface
{
    private array $handlers = [];

    public function __construct()
    {
        $this->registerHandler(new Property\NestedHandler());
        $this->registerHandler(new Property\CollectedKeyHandler());
        $this->registerHandler(new Property\LengthHandler());
        $this->registerHandler(new Property\GetterHandler());
        $this->registerHandler(new Property\TimestampHandler());
        $this->registerHandler(new Property\FromMetadataHandler());
        $this->registerHandler(new Property\FromEnumHandler());
        $this->registerHandler(new Property\CallbackHandler());
        $this->registerHandler(new Prototype\IgnorePropertiesHandler());
        $this->registerHandler(new Prototype\CallbackHandler());
        $this->registerHandler(new Prototype\GeneralPropertyDecoratorsHandler());
    }

    public function registerHandler(DecoratorHandlerInterface $handler): static
    {
        $this->handlers[$handler::class] = $handler;

        return $this;
    }

    public function getHandler(string $className): ?DecoratorHandlerInterface
    {
        return $this->handlers[$className] ?? null;
    }

    public function existsHandler(string $className): bool
    {
        return array_key_exists($className, $this->handlers);
    }

    public function getAllHandler(): array
    {
        return $this->handlers;
    }
}