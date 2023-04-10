<?php

namespace App\Enum;

enum ReportTypeEnum: int
{
    case ProductSelling = 1;
    case NewUsers = 2;
    case Savings = 3;
    case NewLoyalUsers = 4;
    case Refunds = 5;
}
