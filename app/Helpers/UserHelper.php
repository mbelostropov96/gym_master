<?php

namespace App\Helpers;

use App\Enums\UserRole;
use App\Service\DTO\UserDTO;

class UserHelper
{
    /**
     * @param UserDTO $user
     * @return string
     */
    public static function getFullName(UserDTO $user): string
    {
        return sprintf(
            '%s %s %s',
            $user->lastName,
            $user->firstName,
            $user->middleName
        );
    }

    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return auth()->user()->role === UserRole::ADMIN->value;
    }
}
