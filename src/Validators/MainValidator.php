<?php
declare(strict_types=1);

namespace Src\Forms;

use Src\Errors\FormError;

abstract class MainValidator
{
    public const REQUIRED     = 'required';
    public const MIN_LENGTH   = 'min_length';
    public const MAX_LENGTH   = 'max_length';
    public const EMAIL        = 'email';
    public const LOW_LETTER   = 'low_letter';
    public const UPPER_LETTER = 'upper_letter';
    public const NUMBER       = 'number';

    private const ERRORS_MESSAGE = [
        self::REQUIRED     => 'Param is required ',
        self::MIN_LENGTH   => 'Max length have to ',
        self::MAX_LENGTH   => 'Have to contain a upper letter',
        self::EMAIL        => 'Email is not valid',
        self::UPPER_LETTER => 'Have to contain a upper letter',
        self::LOW_LETTER   => 'Have to contain a lower letter',
        self::NUMBER       => 'Have to contain a number',
    ];

    /**
     * @var FormError[]
     */
    protected array $errors = [];

    /**
     * @return array
     */
    abstract protected function getRules(): array;

    /**
     * @param MainForm $form
     *
     * @return array
     */
    public function validate(MainForm $form): array
    {
        $params = $form->getParams();
        $rules = $this->getRules();
        $errors = [];
        foreach ($params as $name => $value) {
            if (isset($rules[$name])) {
                foreach ($rules[$name] as $rule => $ruleValue) {
                    if (is_int($rule)) {
                        $rule = $ruleValue;
                    }

                    $this->rulesChecking($rule, $ruleValue, $value);
                }

                if (!empty($this->errors)) {
                    $errors[$name] = $this->errors;
                    $this->errors = [];
                }
            }
        }

        $requiredParams = $this->getRequiredParams();
        $notFoundRequiredParams = array_diff($requiredParams, array_keys($params));
        foreach ($notFoundRequiredParams as $notFoundRequiredParam) {
            $errors[$notFoundRequiredParam][] = new FormError(self::ERRORS_MESSAGE[self::REQUIRED]);
        }

        return $errors;
    }

    /**
     * @return array
     */
    private function getRequiredParams(): array
    {
        $requiredParams = [];
        foreach ($this->getRules() as $param => $rules) {
            if (in_array(self::REQUIRED, $rules, true)) {
                $requiredParams[] = $param;
            }
        }

        return $requiredParams;
    }

    /**
     * @param int    $length
     * @param string $value
     *
     * @return void
     */
    private function minLength(int $length, string $value): void
    {
        if (strlen($value) < $length) {
            $this->errors[] = new FormError(self::ERRORS_MESSAGE[self::MIN_LENGTH] . $length);
        }
    }

    /**
     * @param int    $length
     * @param string $value
     *
     * @return void
     */
    private function maxLength(int $length, string $value): void
    {
        if (strlen($value) > $length) {
            $this->errors[] = new FormError(self::ERRORS_MESSAGE[self::MAX_LENGTH] . $length);
        }
    }

    /**
     * @param string $string
     *
     * @return void
     */
    private function issetUpperLetter(string $string): void
    {
        if (!preg_match('/[A-Z]/', $string)) {
            $this->errors[] = new FormError(self::ERRORS_MESSAGE[self::UPPER_LETTER]);
        }
    }

    /**
     * @param string $string
     *
     * @return void
     */
    private function issetLowerLetter(string $string): void
    {
        if (!preg_match('/[a-z]/', $string)) {
            $this->errors[] = new FormError(self::ERRORS_MESSAGE[self::LOW_LETTER]);
        }
    }

    /**
     * @param string $string
     *
     * @return void
     */
    private function issetNumber(string $string): void
    {
        if (!preg_match('/\d/', $string)) {
            $this->errors[] = new FormError(self::ERRORS_MESSAGE[self::NUMBER]);
        }
    }

    /**
     * @param string $email
     *
     * @return void
     */
    private function isEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = new FormError(self::ERRORS_MESSAGE[self::EMAIL]);
        }
    }

    /**
     * @param string $rule
     * @param mixed $ruleValue
     * @param mixed $value
     */
    protected function rulesChecking(string $rule, $ruleValue, $value): void
    {
        switch ($rule) {
            case self::MIN_LENGTH:
                $this->minLength($ruleValue, $value);
                break;
            case self::MAX_LENGTH:
                $this->maxLength($ruleValue, $value);
                break;
            case self::NUMBER:
                $this->issetNumber($value);
                break;
            case self::LOW_LETTER:
                $this->issetLowerLetter($value);
                break;
            case self::UPPER_LETTER:
                $this->issetUpperLetter($value);
                break;
            case self::EMAIL:
                $this->isEmail($value);
        }
    }
}