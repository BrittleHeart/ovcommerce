<?php

namespace App\Entity;

use App\Enum\LoyalityCardTypeEnum;
use App\Repository\LoyalityCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoyalityCardRepository::class)]
class LoyalityCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var ArrayCollection<int, User> $for_user
     */
    #[ORM\OneToMany(mappedBy: 'loyalityCard', targetEntity: User::class)]
    private Collection $for_user;

    #[ORM\Column(
        enumType: LoyalityCardTypeEnum::class,
        options: [
            'default' => LoyalityCardTypeEnum::Silver,
        ]
    )]
    private ?int $card_type = null;

    #[ORM\Column(length: 16, unique: true)]
    private ?string $card_number = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $issue_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $expiration_date = null;

    /**
     * @var ArrayCollection<int, LoyalityPoint> $loyalityPoints
     */
    #[ORM\OneToMany(mappedBy: 'card', targetEntity: LoyalityPoint::class)]
    private Collection $loyalityPoints;

    /**
     * @var ArrayCollection<int, LoyalityReward> $loyalityRewards
     */
    #[ORM\OneToMany(mappedBy: 'loyality_card', targetEntity: LoyalityReward::class)]
    private Collection $loyalityRewards;

    #[ORM\Column]
    private ?bool $is_active = null;

    /**
     * @var ArrayCollection<int, UserCardRankingHistory> $userCardRankingHistories
     */
    #[ORM\OneToMany(mappedBy: 'loyality_card', targetEntity: UserCardRankingHistory::class)]
    private Collection $userCardRankingHistories;

    #[ORM\Column]
    private ?bool $is_renewable = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $renewed_at = null;

    public function __construct()
    {
        $this->for_user = new ArrayCollection();
        $this->loyalityPoints = new ArrayCollection();
        $this->loyalityRewards = new ArrayCollection();
        $this->userCardRankingHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getForUser(): Collection
    {
        return $this->for_user;
    }

    public function addForUser(User $forUser): self
    {
        if (!$this->for_user->contains($forUser)) {
            $this->for_user->add($forUser);
            $forUser->setLoyalityCard($this);
        }

        return $this;
    }

    public function removeForUser(User $forUser): self
    {
        if ($this->for_user->removeElement($forUser)) {
            // set the owning side to null (unless already changed)
            if ($forUser->getLoyalityCard() === $this) {
                $forUser->setLoyalityCard(null);
            }
        }

        return $this;
    }

    public function getCardType(): ?int
    {
        return $this->card_type;
    }

    public function setCardType(int $card_type): self
    {
        $this->card_type = $card_type;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    public function setCardNumber(string $card_number): self
    {
        $this->card_number = $card_number;

        return $this;
    }

    public function getIssueDate(): ?\DateTimeImmutable
    {
        return $this->issue_date;
    }

    public function setIssueDate(\DateTimeImmutable $issue_date): self
    {
        $this->issue_date = $issue_date;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeImmutable
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeImmutable $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    /**
     * @return Collection<int, LoyalityPoint>
     */
    public function getLoyalityPoints(): Collection
    {
        return $this->loyalityPoints;
    }

    public function addLoyalityPoint(LoyalityPoint $loyalityPoint): self
    {
        if (!$this->loyalityPoints->contains($loyalityPoint)) {
            $this->loyalityPoints->add($loyalityPoint);
            $loyalityPoint->setCard($this);
        }

        return $this;
    }

    public function removeLoyalityPoint(LoyalityPoint $loyalityPoint): self
    {
        if ($this->loyalityPoints->removeElement($loyalityPoint)) {
            // set the owning side to null (unless already changed)
            if ($loyalityPoint->getCard() === $this) {
                $loyalityPoint->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LoyalityReward>
     */
    public function getLoyalityRewards(): Collection
    {
        return $this->loyalityRewards;
    }

    public function addLoyalityReward(LoyalityReward $loyalityReward): self
    {
        if (!$this->loyalityRewards->contains($loyalityReward)) {
            $this->loyalityRewards->add($loyalityReward);
            $loyalityReward->setLoyalityCard($this);
        }

        return $this;
    }

    public function removeLoyalityReward(LoyalityReward $loyalityReward): self
    {
        if ($this->loyalityRewards->removeElement($loyalityReward)) {
            // set the owning side to null (unless already changed)
            if ($loyalityReward->getLoyalityCard() === $this) {
                $loyalityReward->setLoyalityCard(null);
            }
        }

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, UserCardRankingHistory>
     */
    public function getUserCardRankingHistories(): Collection
    {
        return $this->userCardRankingHistories;
    }

    public function addUserCardRankingHistory(UserCardRankingHistory $userCardRankingHistory): self
    {
        if (!$this->userCardRankingHistories->contains($userCardRankingHistory)) {
            $this->userCardRankingHistories->add($userCardRankingHistory);
            $userCardRankingHistory->setLoyalityCard($this);
        }

        return $this;
    }

    public function removeUserCardRankingHistory(UserCardRankingHistory $userCardRankingHistory): self
    {
        if ($this->userCardRankingHistories->removeElement($userCardRankingHistory)) {
            // set the owning side to null (unless already changed)
            if ($userCardRankingHistory->getLoyalityCard() === $this) {
                $userCardRankingHistory->setLoyalityCard(null);
            }
        }

        return $this;
    }

    public function isIsRenewable(): ?bool
    {
        return $this->is_renewable;
    }

    public function setIsRenewable(bool $is_renewable): self
    {
        $this->is_renewable = $is_renewable;

        return $this;
    }

    public function getRenewedAt(): ?\DateTimeInterface
    {
        return $this->renewed_at;
    }

    public function setRenewedAt(?\DateTimeInterface $renewed_at): self
    {
        $this->renewed_at = $renewed_at;

        return $this;
    }
}
