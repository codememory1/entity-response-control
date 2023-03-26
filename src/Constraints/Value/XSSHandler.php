<?php

namespace Codememory\EntityResponseControl\Constraints\Value;

use Codememory\EntityResponseControl\ConstraintTypeControl;
use Codememory\EntityResponseControl\Interfaces\ConstraintInterface;
use Codememory\EntityResponseControl\Interfaces\ValueConverterConstraintHandlerInterface;
use const ENT_DISALLOWED;
use const ENT_HTML401;
use const ENT_HTML5;
use const ENT_QUOTES;
use const ENT_SUBSTITUTE;
use const ENT_XHTML;
use const ENT_XML1;
use function is_array;
use function is_string;

final class XSSHandler implements ValueConverterConstraintHandlerInterface
{
    /**
     * @param XSS $constraint
     */
    public function handle(ConstraintInterface $constraint, ConstraintTypeControl $constraintTypeControl): mixed
    {
        $value = $constraintTypeControl->getValue();

        if (is_string($value)) {
            return $this->filter($value);
        } else if (is_array($value)) {
            return $this->arrayFilter($value);
        }

        return $value;
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