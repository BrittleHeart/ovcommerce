<?php

namespace App\Enum;

enum UserPaymentStatusEnum: int
{
    public const Submitted = 1;
    public const InValidation = 2;
    public const Rejected = 3;
    public const Accepted = 4;
}
