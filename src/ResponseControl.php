<?php

namespace Codememory\EntityResponseControl;

use Codememory\EntityResponseControl\Adapters\ReflectionAdapter;
use Codememory\EntityResponseControl\Interfaces\ObjectDisassemblerInterface;
use Codememory\EntityResponseControl\Interfaces\ResponseControlInterface;
use function is_object;

class ResponseControl implements ResponseControlInterface
{
    protected readonly ReflectionAdapter $reflectionAdapter;
    protected array|object $data = [];
    protected bool $asOne = false;
    protected array $collectedResponse = [];

    public function __construct(
        protected readonly ObjectDisassemblerInterface $objectDisassembler
    ) {
        $this->reflectionAdapter = new ReflectionAdapter(static::class);
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
                ->disassemble($object, $this, $this->reflectionAdapter)
                ->toArray();
        }

        return $this;
    }
}