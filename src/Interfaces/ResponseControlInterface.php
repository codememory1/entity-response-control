<?php

namespace Codememory\EntityResponseControl\Interfaces;

interface ResponseControlInterface
{
    /**
     * @param array<int, object>|object $data
     */
    public function setData(array|object $data): self;

    public function getObjectDisassembler(): ObjectDisassemblerInterface;

    public function toArray(): array;

    public function collect(): self;
}