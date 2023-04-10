<?php

namespace App\Enum;

enum UserPaymentStatusEnum: int
{
    case Submitted = 1;
    case InValidation = 2;
    case Rejected = 3;
    case Accepted = 4;
}
