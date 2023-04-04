<?php

namespace App\Entity;

use App\Enum\ReportDataTypeEnum;
use App\Enum\ReportTypeEnum;
use App\Repository\ReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: ReportTypeEnum::class)]
    private ?int $report_type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $report_date = null;

    #[ORM\Column(enumType: ReportDataTypeEnum::class)]
    private ?int $report_data_type = null;

    #[ORM\Column(
        options: ['default' => 'now()'],
    )]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(
        options: ['default' => 'now()'],
        type: Types::DATETIME_MUTABLE
    )]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportType(): ?int
    {
        return $this->report_type;
    }

    public function setReportType(int $report_type): self
    {
        $this->report_type = $report_type;

        return $this;
    }

    public function getReportDate(): ?\DateTimeImmutable
    {
        return $this->report_date;
    }

    public function setReportDate(\DateTimeImmutable $report_date): self
    {
        $this->report_date = $report_date;

        return $this;
    }

    public function getReportDataType(): ?int
    {
        return $this->report_data_type;
    }

    public function setReportDataType(int $report_data_type): self
    {
        $this->report_data_type = $report_data_type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
