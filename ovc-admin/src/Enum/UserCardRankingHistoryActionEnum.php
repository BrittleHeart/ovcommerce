<?php

namespace App\Enum;

enum UserCardRankingHistoryActionEnum: int
{
    case NewCard = 1;
    case CardRankingChanged = 2;
    case CardRankingExpired = 3;
    case CardRankingRenewed = 4;
}