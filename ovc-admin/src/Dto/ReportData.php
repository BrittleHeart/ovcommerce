<?php

namespace App\Dto;

class ReportData extends Dto
{
    public function __construct(
        public string $report_name,
        public int $report_type,
        public int $report_data_type,
        public string|\DateTimeImmutable $report_date,
        public string|\DateTimeInterface $start_date,
        public string|\DateTimeInterface $end_date,
    ) {
    }
}
