<?php

namespace App\ReportGenerator;

use App\Contract\ReportGeneratorInterface;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class ReportGenerator
{
    /**
     * Reports directory, that end files would be stored.
     * It's important to customize it if necessary.
     *
     * @const string REPORTS_DIR
     */
    protected const REPORTS_DIR = 'reports';

    /**
     * File path determinate the end of storage path.
     * Currently, it is set to /public/REPORTS_DIR.
     */
    protected string $filePath;

    /**
     * Report fields that should be used when creating a new report.
     * These fields may be customized by addFields static method.
     *
     * @var array<int|string, scalar>
     */
    protected static array $reportFields = [];

    /**
     * Determinate the file name, that should be used as a default value.
     * In case when something goes wrong, this name would be used.
     */
    protected string $reportName = 'dummy_report';

    private static KernelInterface $kernel;

    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly KernelInterface $kernelInterface,
    ) {
        self::$kernel = $this->kernelInterface;

        $this->filePath = sprintf(
            '%s/public/%s',
            self::$kernel->getProjectDir(),
            self::REPORTS_DIR
        );

        if (!is_dir($this->filePath)) {
            @mkdir($this->filePath);
        }

        $this->reportName = '';
    }

    /**
     * Gets strategy that should be used for current report generator.
     * Only classes, that implements ReportGeneratorInterface, can be used as strategy.
     */
    public static function getStrategy(ReportGeneratorInterface $strategy): ?ReportGeneratorInterface
    {
        if (!class_implements($strategy)) {
            return null;
        }

        return $strategy;
    }

    /**
     * Add fields to the report file content.
     * @param array<int|string, scalar> $fields
     *
     * @return array<int|string, scalar>
     */
    public static function addFields(array $fields): array
    {
        foreach ($fields as $field) {
            static::$reportFields[] = $field;
        }

        return static::$reportFields;
    }

    public function setReportName(string $reportName): self
    {
        $this->reportName = $reportName;

        return $this;
    }

    /**
     * Auxiliary method for creating report, based on new business assumptions.
     * It is not required to use this exact method, but could be helpful.
     */
    abstract protected function createReport(): ?bool;
}
