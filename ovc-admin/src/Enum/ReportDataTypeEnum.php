<?php

namespace App\Enum;

enum ReportDataTypeEnum: int
{
    case Json = 1;
    case Csv = 2;
    case Pdf = 3;
}
