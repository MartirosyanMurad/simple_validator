<?php
declare(strict_types=1);

namespace Src\Forms;

use Src\Errors\FormError;

interface MainForm
{
    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return FormError[]
     */
    public function getErrors(): array;

    /**
     * @return array
     */
    public function getParams(): array;
}