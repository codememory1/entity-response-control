<?php

namespace Codememory\EntityResponseControl\Decorators;

use Codememory\EntityResponseControl\Interfaces\DecoratorHandlerInterface;
use Codememory\EntityResponseControl\Interfaces\DecoratorInterface;
use Codememory\EntityResponseControl\Interfaces\ExecutionContextInterface;
use const ENT_DISALLOWED;
use const ENT_HTML401;
use const ENT_HTML5;
use const ENT_QUOTES;
use const ENT_SUBSTITUTE;
use const ENT_XHTML;
use const ENT_XML1;
use function is_array;
use function is_string;

final class XSSHandler implements DecoratorHandlerInterface
{
    /**
     * @param XSS $decorator
     */
    public function handle(DecoratorInterface $decorator, ExecutionContextInterface $context): void
    {
        $value = $context->getValue();

        if (is_string($value)) {
            $context->setValue($this->filter($value));
        } else if (is_array($value)) {
            $context->setValue($this->arrayFilter($value));
        } else {
            $context->setValue($value);
        }
    }

    private function filter(string $value): string
    {
        return htmlspecialchars(
            $value,
            ENT_QUOTES | ENT_HTML401 | ENT_HTML5 | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_XML1 | ENT_XHTML,
            'UTF-8'
        );
    }

    private function arrayFilter(array $array): array
    {
        foreach ($array as &$value) {
            if (is_string($value)) {
                $value = $this->filter($value);
            } else if (is_array($value)) {
                $value = $this->arrayFilter($value);
            }
        }

        return $array;
    }
}