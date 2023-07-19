<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Exception\DecoratorHandlerNotRegisteredException;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerRegistrarInterface;

class DecoratorHandlerRegistrar implements DecoratorHandlerRegistrarInterface
{
    /**
     * @var array<int, DecoratorHandlerInterface>
     */
    protected array $handlers = [];

    public function __construct()
    {
        $this->register(new Decorators\NestedPrototypeHandler());
        $this->register(new Decorators\CountHandler());
        $this->register(new Decorators\BoolTransformerHandler());
        $this->register(new Decorators\FromEnumHandler());
        $this->register(new Decorators\DateTimeHandler());
        $this->register(new Decorators\CropStringHandler());
        $this->register(new Decorators\MaxElementsHandler());
        $this->register(new Decorators\CallbackHandler());
        $this->register(new Decorators\ArrayValuesHandler());
        $this->register(new Decorators\XSSHandler());
        $this->register(new Decorators\AliasInResponseHandler());
        $this->register(new Decorators\CustomHandler());
        $this->register(new Decorators\PrefixHandler());
        $this->register(new Decorators\PrototypeObjectGetterMethodHandler());
        $this->register(new Decorators\HiddenNullableHandler());
    }

    public function register(DecoratorHandlerInterface $handler): DecoratorHandlerRegistrarInterface
    {
        if (!array_key_exists($handler::class, $this->handlers)) {
            $this->handlers[$handler::class] = $handler;
        }

        return $this;
    }

    public function getHandlers(): array
    {
        return $this->handlers;
    }

    /**
     * @throws DecoratorHandlerNotRegisteredException
     */
    public function getHandler(string $namespace): DecoratorHandlerInterface
    {
        return $this->handlers[$namespace] ?? throw new DecoratorHandlerNotRegisteredException($namespace);
    }
}