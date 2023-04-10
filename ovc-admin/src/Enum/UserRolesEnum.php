<?php

namespace App\Enum;

enum UserRolesEnum: string
{
    case Admin = 'ROLE_ADMIN';
    case Operator = 'ROLE_OPERATOR';
    case Service = 'ROLE_SERVICE';
    case User = 'ROLE_USER';
}
