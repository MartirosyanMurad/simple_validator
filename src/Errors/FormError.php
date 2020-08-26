<?php
declare(strict_types=1);

namespace Src\Errors;

class FormError
{

    /** @var string*/
    private string $message;

    /**
     * MainError constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}