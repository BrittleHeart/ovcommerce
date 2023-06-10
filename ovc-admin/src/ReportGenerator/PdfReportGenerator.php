<?php

namespace App\ReportGenerator;

use App\Contract\ReportGeneratorInterface;
use App\Parser\CsvFileParser;
use App\Parser\FileParser;

class PdfReportGenerator extends ReportGenerator implements ReportGeneratorInterface
{
    protected function createReport(): ?bool
    {
        return null;
    }

    public function generate(): self
    {
        return $this;
    }
}
