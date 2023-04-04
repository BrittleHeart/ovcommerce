<?php

namespace App\Enum;

enum ReportTypeEnum: int
{
    public const ProductSelling = 1;
    public const NewUsers = 2;
    public const Savings = 3;
    public const NewLoyalUsers = 4;
    public const Refunds = 5;
}
