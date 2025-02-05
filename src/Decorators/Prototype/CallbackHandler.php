<?php

namespace Codememory\EntityResponseControl\Decorators\Prototype;

use Codememory\EntityResponseControl\Exceptions\ResponsePrototypeException;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeDecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\PrototypeExecutionContextInterface;
use function is_array;
use function is_string;

class CallbackHandler implements PrototypeDecoratorHandlerInterface
{
    /**
     * @param Callback $decorator
     *
     * @throws ResponsePrototypeException
     */
    public function process(PrototypeDecoratorInterface $decorator, PrototypeExecutionContextInterface $executionContext): void
    {
        if (is_array($decorator->callback)) {
            $this->throwIfMethodNotFound($executionContext, $decorator->callback[0], $decorator->callback[1]);

            $decorator->callback[0]::{$decorator->callback[1]}($executionContext);
        } else if (is_string($decorator->callback)) {
            $this->throwIfMethodNotFound($executionContext, $executionContext->getClassReflector()->getName(), $decorator->callback);

            $executionContext->getClassReflector()->getName()::{$decorator->callback}($executionContext);
        }
    }

    /**
     * @throws ResponsePrototypeException
     */
    private function throwIfMethodNotFound(PrototypeExecutionContextInterface $executionContext, string $class, string $method): void
    {
        if (!method_exists($class, $method)) {
            throw new ResponsePrototypeException($executionContext->getClassReflector()->getName(), "Static method \"{$method}\" in class \"{$class}\" not found.");
        }
    }
}