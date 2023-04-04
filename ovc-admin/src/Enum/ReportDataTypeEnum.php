<?php

namespace App\Enum;

enum ReportDataTypeEnum: int
{
    public const Json = 1;
    public const Csv = 2;
    public const Pdf = 3;
}
