<?php

namespace App\ReportGenerator;

use App\Contract\ReportGeneratorInterface;

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
