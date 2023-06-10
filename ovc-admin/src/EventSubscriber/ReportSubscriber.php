<?php

namespace App\EventSubscriber;

use App\Contract\ReportGeneratorInterface;
use App\Dto\ReportData;
use App\Entity\Report;
use App\Enum\ReportDataTypeEnum;
use App\Enum\ReportTypeEnum;
use App\ReportGenerator\CsvReportGenerator;
use App\ReportGenerator\JsonReportGenerator;
use App\ReportGenerator\PdfReportGenerator;
use App\ReportGenerator\ReportGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Event\EntityLifecycleEventInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

readonly class ReportSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private KernelInterface $kernel,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function onBeforeReportCreatedEvent(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if (!$entity instanceof Report) {
            return;
        }

        $reportName = (string) $entity->getReportName();
        $reportDataType = ReportTypeEnum::from((int) $entity->getReportDataType());
        $reportType = ReportDataTypeEnum::from((int) $entity->getReportType());
        $reportDate = $entity->getReportDate() ?? new \DateTimeImmutable();
        $reportStartedDate = $entity->getStartDate() ?? new \DateTime();
        $reportEndDate = $entity->getEndDate() ?? new \DateTime();

        // Creating DTO object, that hold all fields, that are required for all reports
        $reportData = new ReportData(
            $reportName,
            $reportDataType->value,
            $reportType->value,
            $reportDate->format('Y-m-d H:i:s'),
            $reportStartedDate->format('Y-m-d H:i:s'),
            $reportEndDate->format('Y-m-d H:i:s'),
        );

        // Determinate the strategy based on report data type
        $strategy = $this->determinateStrategy(ReportDataTypeEnum::from($reportDataType->value));

        // Choosing strategy that should be used
        $generator = ReportGenerator::getStrategy($strategy);
        if (null === $generator) {
            throw new \Exception("It seems that there's no strategy for {$reportDataType->name} data type");
        }

        // Here, we are adding all fields
        ReportGenerator::addFields($reportData->toArray());

        // Setting up the report name
        if (method_exists($generator, 'setReportName')) {
            $generator
                ->setReportName($reportName);
        }

        // Generating a new report
        $generator->generate();
    }

    /**
     * Determinate the strategy based on ReportDataTypeEnum passed by $entity.
     *
     * @throws \Exception
     */
    protected function determinateStrategy(ReportDataTypeEnum $reportDataType): ReportGeneratorInterface
    {
        return match ($reportDataType) {
            ReportDataTypeEnum::Json => new JsonReportGenerator($this->kernel),
            ReportDataTypeEnum::Csv => new CsvReportGenerator($this->kernel),
            ReportDataTypeEnum::Pdf => new PdfReportGenerator($this->kernel),
        };
    }

    /**
     * @return array<class-string<EntityLifecycleEventInterface>, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'onBeforeReportCreatedEvent',
        ];
    }
}
