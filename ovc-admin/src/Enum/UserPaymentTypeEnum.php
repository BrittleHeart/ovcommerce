<?php

namespace App\Enum;

enum UserPaymentTypeEnum: int
{
    case Cash = 1;
    case CreditCard = 2;
    case DebitCard = 3;
    case LoyalityCard = 4;
    case BankTransfer = 5;
    case PayPal = 6;
    case Other = 7;
}
