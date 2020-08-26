<?php
declare(strict_types=1);

namespace Src\Forms;

use Src\Errors\FormError;

class ProductValidator extends MainValidator
{
    private const FIRST_LETTER_IS_UPPER = 'first_letter_upper';
    private const IS_NUMERIC = 'is_numeric';

    private const CUSTOM_ERRORS_MESSAGE = [
        self::FIRST_LETTER_IS_UPPER => 'First letter have to uppercase',
        self::IS_NUMERIC => 'Have to been numeric',
    ];

    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'name' => [self::REQUIRED, self::FIRST_LETTER_IS_UPPER, self::MIN_LENGTH => 2, self::MAX_LENGTH => 20],
            'count' => [self::REQUIRED, self::IS_NUMERIC],
            'description' => [self::REQUIRED, self::MIN_LENGTH => 5, self::MAX_LENGTH =>120],
        ];
    }

    /**
     * @param string $rule
     * @param        $ruleValue
     * @param mixed  $value
     */
    protected function rulesChecking(string $rule, $ruleValue, $value): void
    {
        switch ($rule) {
            case self::FIRST_LETTER_IS_UPPER:
                $this->firstLetterIsUpper($value);
                break;
            case self::IS_NUMERIC:
                $this->isNumber($value);
        }
        
        parent::rulesChecking($rule, $ruleValue, $value);
    }

    /**
     * @param string $value
     */
    private function firstLetterIsUpper(string $value): void
    {
        if (!ctype_upper($value[0])) {
            $this->errors[] = new FormError(self::CUSTOM_ERRORS_MESSAGE[self::FIRST_LETTER_IS_UPPER]);

        }
    }

    /**
     * @param $value
     */
    private function isNumber($value): void
    {
        if (!is_numeric($value)) {
            $this->errors[] = new FormError(self::CUSTOM_ERRORS_MESSAGE[self::IS_NUMERIC]);

        }
    }
}