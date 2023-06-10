<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[Orm\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @TODO: Add migration and fix ReportGenerator to generate not to parse
     */
    #[ORM\Column]
    private ?string $report_name = null;

    #[ORM\Column]
    private ?int $report_type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $report_date = null;

    #[ORM\Column]
    private ?int $report_data_type = null;

    #[ORM\Column(
        options: ['default' => 'now()'],
    )]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        options: ['default' => 'now()']
    )]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\LessThan(propertyPath: 'end_date')]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan(propertyPath: 'start_date')]
    private ?\DateTimeInterface $end_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportName(): ?string
    {
        return $this->report_name;
    }

    public function setReportName(?string $report_name): void
    {
        $this->report_name = $report_name;
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

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
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

    #[ORM\PrePersist]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime();
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }
}
