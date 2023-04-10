<?php

namespace App\Enum;

enum UserAccountActionEnum: int 
{
    case Open = 1;
    case Blocked = 2;
    case TemporamentlyClosed = 3;
    case Closed = 4;
}
