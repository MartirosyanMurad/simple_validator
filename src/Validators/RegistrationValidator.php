<?php
declare(strict_types=1);

namespace Src\Forms;

class RegistrationValidator extends MainValidator
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'username' => [self::REQUIRED, self::MIN_LENGTH => 3, self::MAX_LENGTH => 15],
            'name'     => [],
            'email'    => [self::REQUIRED, self::EMAIL],
            'password' => [self::REQUIRED, self::LOW_LETTER, self::UPPER_LETTER, self::NUMBER, self::MIN_LENGTH => 6, self::MAX_LENGTH => 20],
        ];
    }
}