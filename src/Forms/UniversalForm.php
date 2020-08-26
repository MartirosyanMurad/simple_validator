<?php
declare(strict_types=1);

namespace Src\Forms;

use Src\Errors\FormError;

class UniversalForm implements MainForm
{
    /** @var array */
    private array $params;

    /** @var MainValidator */
    private MainValidator $validator;

    /** @var array */
    private array $errors;

    /** @var array */
    private array $validData = [];

    /**
     * RegistrationForm constructor.
     *
     * @param array                 $params
     * @param MainValidator $validator
     */
    public function __construct(array $params, MainValidator $validator)
    {
        $this->params = $params;
        $this->errors = $validator->validate($this);
    }

    public function __set($name, $value)
    {
        $this->validData[$name] = $value;
    }

    public function __get($name)
    {
        return $this->validData[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function isValid(): bool
    {
        if (empty($this->errors)) {
            $this->setParams();
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $message = [];
        foreach ($this->errors as $param => $errors) {
            /** @var $errors FormError[] */
            foreach ($errors as $error) {
                $message[$param][] = $error->getMessage();
            }
        }

        return $message;
    }

    private function setParams(): void
    {
        foreach ($this->params as $name => $value) {
            $this->{$name} = $value;
        }
    }
}