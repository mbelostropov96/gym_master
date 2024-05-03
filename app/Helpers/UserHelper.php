<?php

namespace App\Helpers;

use App\Service\DTO\UserDTO;

class UserHelper
{
    public static function getFullName(UserDTO $user): string
    {
        return sprintf('%s %s %s',
            $user->lastName,
            $user->firstName,
            $user->middleName
        );
    }
}
