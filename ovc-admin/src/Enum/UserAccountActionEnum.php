<?php

namespace App\Enum;

enum UserAccountActionEnum: int
{
    public const Open = 1;
    public const Blocked = 2;
    public const TemporamentlyClosed = 3;
    public const Closed = 4;
}
