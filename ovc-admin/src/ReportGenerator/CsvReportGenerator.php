<?php

namespace App\ReportGenerator;

use App\Contract\ReportGeneratorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class CsvReportGenerator extends ReportGenerator implements ReportGeneratorInterface
{
    protected function createReport(): ?bool
    {
        // TODO: Check if csv folder exists and it's writeable / readable
        $reportPath = "{$this->filePath}/csv/{$this->reportName}.csv";
        $reportFile = @fopen($reportPath, 'w');
        if (false === $reportFile) {
            throw new FileNotFoundException($reportPath);
        }

        $csvData = fputcsv($reportFile, static::$reportFields);
        if (false === $csvData) {
            return false;
        }

        @fclose($reportFile);

        return true;
    }

    /**
     * @throws \Exception
     */
    public function generate(): self
    {
        if (false === $this->createReport()) {
            throw new \Exception('Could not create CSV report');
        }

        return $this;
    }
}
