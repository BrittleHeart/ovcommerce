<?php

namespace App\Entity;

use App\Enum\UserCardRankingHistoryActionEnum;
use App\Repository\UserCardRankingHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCardRankingHistoryRepository::class)]
class UserCardRankingHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCardRankingHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $for_user = null;

    #[ORM\ManyToOne(inversedBy: 'userCardRankingHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LoyalityCard $loyality_card = null;

    #[ORM\Column(enumType: UserCardRankingHistoryActionEnum::class)]
    private ?int $action = null;

    #[ORM\Column(
        options: ['default' => 'now()']
    )]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForUser(): ?User
    {
        return $this->for_user;
    }

    public function setForUser(?User $for_user): self
    {
        $this->for_user = $for_user;

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

    public function getAction(): ?int
    {
        return $this->action;
    }

    public function setAction(int $action): self
    {
        $this->action = $action;

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
}
