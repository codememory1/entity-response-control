<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\Interfaces\ResponseControlInterface;
use Codememory\Reflection\ReflectorManager;
use Codememory\Reflection\Reflectors\ClassReflector;
use function is_object;
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
        protected readonly ReflectorManager $reflectorManager
    ) {
        $this->reflector = $this->reflectorManager->getReflector(static::class);
    }

    public function getReflectorManager(): ReflectorManager
    {
        return $this->reflectorManager;
    }

    public function setData(object|array $data): ResponseControlInterface
    {
        $this->data = is_object($data) ? [$data] : $data;
        $this->asOne = is_object($data);

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