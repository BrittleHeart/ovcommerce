<?php

namespace App\Entity;

use App\Enum\RewardTypeEnum;
use App\Repository\LoyalityRewardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyalityRewardRepository::class)]
class LoyalityReward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $points_required = null;

    #[ORM\Column(enumType: RewardTypeEnum::class)]
    private ?int $reward_type = null;

    #[ORM\Column(nullable: true)]
    private ?int $reward_value = null;

    #[ORM\ManyToOne(inversedBy: 'loyalityRewards')]
    private ?LoyalityCard $loyality_card = null;

    #[ORM\Column(
        options: ['default' => 'now()']
    )]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPointsRequired(): ?int
    {
        return $this->points_required;
    }

    public function setPointsRequired(int $points_required): self
    {
        $this->points_required = $points_required;

        return $this;
    }

    public function getRewardType(): ?int
    {
        return $this->reward_type;
    }

    public function setRewardType(int $reward_type): self
    {
        $this->reward_type = $reward_type;

        return $this;
    }

    public function getRewardValue(): ?int
    {
        return $this->reward_value;
    }

    public function setRewardValue(int $reward_value): self
    {
        $this->reward_value = $reward_value;

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

    public function getLoyalityCard(): ?LoyalityCard
    {
        return $this->loyality_card;
    }

    public function setLoyalityCard(?LoyalityCard $loyality_card): self
    {
        $this->loyality_card = $loyality_card;

        return $this;
    }
}
