<?php

namespace App\Enum;

enum RewardTypeEnum: int 
{
  case Discount = 1;
  case Gift = 2;
  case FreeShipping = 3;
}