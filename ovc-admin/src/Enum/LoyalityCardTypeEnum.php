<?php

namespace App\Enum;

enum LoyalityCardTypeEnum: int
{
    case Silver = 1;
    case Gold = 2;
    case Platinum = 3;
    case Diamond = 4;
    case VIP = 5;
}
