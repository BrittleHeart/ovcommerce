<?php

namespace App\Enum;

enum UserAccountStatusEnum: int
{
    case Open = 1;
    case Blocked = 2;
    case TemporamentlyClosed = 3;
    case Closed = 4;
    case EmailNotVerified = 5;
}
