<?php

namespace App\Enum;

enum UserPaymentTypeEnum: int
{
    public const Cash = 1;
    public const CreditCard = 2;
    public const DebitCard = 3;
    public const LoyalityCard = 4;
    public const BankTransfer = 5;
    public const PayPal = 6;
    public const Other = 7;
}
