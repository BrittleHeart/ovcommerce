<?php

namespace App\Enum;

enum UserAccountStatusEnum: int
{
    public const Open = 1;
    public const Blocked = 2;
    public const TemporamentlyClosed = 3;
    public const Closed = 4;
    public const EmailNotVerified = 5;
}
