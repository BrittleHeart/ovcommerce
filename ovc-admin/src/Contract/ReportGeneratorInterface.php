<?php

namespace App\Contract;

interface ReportGeneratorInterface
{
    /**
     * Generates a report based on the current context.
     */
    public function generate(): self;
}
