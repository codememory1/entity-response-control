<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\Interfaces\ResponseControlInterface;
use Codememory\EntityResponseControl\Registers\ConstraintHandlerRegister;
use Codememory\EntityResponseControl\Registers\ConstraintTypeHandlerRegister;
use Codememory\Reflection\ReflectorManager;
use Codememory\Reflection\Reflectors\ClassReflector;
use function is_object;
use IteratorAggregate;
use Psr\Cache\InvalidArgumentException;
use ReflectionException;

class ResponseControl implements ResponseControlInterface
{
    protected ClassReflector $reflector;
    protected array|object $data = [];
    protected bool $asOne = false;
    protected array $collectedResponse = [];

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected readonly ObjectDisassemblerInterface $objectDisassembler,
        protected readonly ReflectorManager $reflectorManager,
        protected readonly ConstraintTypeHandlerRegister $constraintTypeHandlerRegister,
        protected readonly ConstraintHandlerRegister $constraintHandlerRegister
    ) {
        $this->reflector = $this->reflectorManager->getReflector(static::class);
    }

    public function getReflectorManager(): ReflectorManager
    {
        return $this->reflectorManager;
    }

    public function getConstraintTypeHandlerRegister(): ConstraintTypeHandlerRegister
    {
        return $this->constraintTypeHandlerRegister;
    }

    public function getConstraintHandlerRegister(): ConstraintHandlerRegister
    {
        return $this->constraintHandlerRegister;
    }

    public function setData(object|array $data): ResponseControlInterface
    {
        if ($data instanceof IteratorAggregate) {
            $this->data = $data;
        } else if (is_object($data)) {
            $this->data = [$data];
            $this->asOne = true;
        } else {
            $this->data = $data;
        }

        return $this;
    }

    public function getObjectDisassembler(): ObjectDisassemblerInterface
    {
        return $this->objectDisassembler;
    }

    public function toArray(): array
    {
        if ($this->asOne && [] !== $this->collectedResponse) {
            return $this->collectedResponse[array_key_first($this->collectedResponse)];
        }

        return $this->collectedResponse;
    }

    public function collect(): self
    {
        foreach ($this->data as $object) {
            $this->collectedResponse[] = $this->getObjectDisassembler()
                ->disassemble($object, $this, $this->reflector)
                ->toArray();
        }

        return $this;
    }
}