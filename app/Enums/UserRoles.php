<?php

namespace App\Enums;

enum UserRoles: string
{
    case CLIENT = 'client';
    case ADMIN = 'admin';
    case INSTRUCTOR = 'instructor';
}
