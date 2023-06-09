<?php

namespace App\Entity;

use App\Repository\LoyalityPointRepository;
use App\Validator as OvValidator;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[OvValidator\LoyaltyPoint]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: LoyalityPointRepository::class)]
class LoyalityPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'loyalityPoints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LoyalityCard $card = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(
        options: ['default' => 'now()'],
    )]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(
        type: Types::DATE_MUTABLE,
        options: ['default' => 'now()']
    )]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCard(): ?LoyalityCard
    {
        return $this->card;
    }

    public function setCard(?LoyalityCard $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

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
        $this->updated_at = new \DateTimeImmutable();
    }
}
