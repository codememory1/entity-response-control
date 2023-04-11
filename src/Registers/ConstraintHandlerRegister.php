<?php

namespace Codememory\EntityResponseControl\Registers;

use Codememory\EntityResponseControl\Constraints\Availability\HiddenNullableHandler;
use Codememory\EntityResponseControl\Constraints\System\AliasInResponseHandler;
use Codememory\EntityResponseControl\Constraints\System\CustomHandler;
use Codememory\EntityResponseControl\Constraints\System\GetterMethodNameHandler;
use Codememory\EntityResponseControl\Constraints\System\PrefixHandler;
use Codememory\EntityResponseControl\Constraints\Value\ArrayValuesHandler;
use Codememory\EntityResponseControl\Constraints\Value\BooleanToHandler;
use Codememory\EntityResponseControl\Constraints\Value\CallbackHandler;
use Codememory\EntityResponseControl\Constraints\Value\CallbackResponseHandler;
use Codememory\EntityResponseControl\Constraints\Value\CountHandler;
use Codememory\EntityResponseControl\Constraints\Value\CropStringHandler;
use Codememory\EntityResponseControl\Constraints\Value\DateTimeHandler;
use Codememory\EntityResponseControl\Constraints\Value\FromEnumHandler;
use Codememory\EntityResponseControl\Constraints\Value\MaxElementsHandler;
use Codememory\EntityResponseControl\Constraints\Value\XSSHandler;
use Codememory\EntityResponseControl\Exception\ConstraintHandlerNotFoundException;
use Codememory\EntityResponseControl\Interfaces\ConstraintHandlerInterface;
use LogicException;

class ConstraintHandlerRegister
{
    protected array $handlers;

    public function __construct()
    {
        $this->register(new AliasInResponseHandler());
        $this->register(new CustomHandler());
        $this->register(new PrefixHandler());
        $this->register(new GetterMethodNameHandler());

        $this->register(new CountHandler());
        $this->register(new CallbackHandler());
        $this->register(new CallbackResponseHandler());
        $this->register(new DateTimeHandler());
        $this->register(new FromEnumHandler());
        $this->register(new ArrayValuesHandler());
        $this->register(new XSSHandler());
        $this->register(new CropStringHandler());
        $this->register(new MaxElementsHandler());
        $this->register(new BooleanToHandler());

        $this->register(new HiddenNullableHandler());
    }

    public function register(ConstraintHandlerInterface $constraintHandler): void
    {
        $constraintHandlerNamespace = $constraintHandler::class;

        if (array_key_exists($constraintHandlerNamespace, $this->handlers)) {
            throw new LogicException("Constraint handler {$constraintHandlerNamespace} is already registered");
        }

        $this->handlers[$constraintHandlerNamespace] = $constraintHandler;
    }

    public function getHandler(string $namespace): ?ConstraintHandlerInterface
    {
        if (!array_key_exists($namespace, $this->handlers)) {
            throw new ConstraintHandlerNotFoundException($namespace);
        }

        return $this->handlers[$namespace] ?? null;
    }
}