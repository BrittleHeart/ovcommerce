<?php

namespace App\Entity;

use App\Enum\LoyalityCardTypeEnum;
use App\Enum\RewardTypeEnum;
use App\Repository\LoyalityCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\ByteString;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: LoyalityCardRepository::class)]
class LoyalityCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['default' => LoyalityCardTypeEnum::Silver->value])]
    private ?int $card_type = null;

    #[ORM\Column(length: 16, unique: true)]
    private ?string $card_number = null;

    #[Assert\LessThan(propertyPath: 'expiration_date')]
    #[ORM\Column]
    private ?\DateTimeImmutable $issue_date = null;

    #[Assert\GreaterThan(propertyPath: 'issue_date')]
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

    #[ORM\OneToOne(mappedBy: 'loyality_card', cascade: ['persist', 'remove'])]
    private ?User $holder = null;

    #[ORM\Column(options: ['default' => LoyalityCardTypeEnum::Silver->value])]
    private ?int $previous_card_type = null;

    public function __construct()
    {
        $this->loyalityPoints = new ArrayCollection();
        $this->loyalityRewards = new ArrayCollection();
        $this->userCardRankingHistories = new ArrayCollection();
    }

    /**
     * @psalm-suppress InvalidToString
     * @psalm-suppress NullableReturnStatement
     */
    public function __toString(): string
    {
        $isCardActive = $this->is_active ? 'Active' : 'InActive';

        return "$this->card_number[$isCardActive]";
    }

    public function getId(): ?int
    {
        return $this->id;
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

    #[Orm\PrePersist]
    public function setCardTypeValue(): void
    {
        $this->card_type = LoyalityCardTypeEnum::Silver->value;
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

    #[ORM\PrePersist]
    public function setCardNumberValue(): void
    {
        $this->card_number = ByteString::fromRandom(
            16,
            'abdeffgijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789'
        )->toString();
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
     * @throws \Exception
     */
    public function isExpired(): bool
    {
        $current = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Warsaw'));

        return $current > $this->getExpirationDate();
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

    public function countPoints(): int
    {
        $loyaltyPoints = 0;

        foreach ($this->loyalityPoints as $loyaltyPoint) {
            $loyaltyPoints += $loyaltyPoint->getPoints() ?? 0;
        }

        return $loyaltyPoints;
    }

    /**
     * @return Collection<int, LoyalityReward>
     */
    public function getLoyalityRewards(): Collection
    {
        return $this->loyalityRewards;
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function getLoyalityRewardsType(): ?array
    {
        $rewardsType = [];

        $loyalityRewards = $this->getLoyalityRewards();
        if (!count($loyalityRewards)) {
            return null;
        }

        foreach ($this->getLoyalityRewards() as $reward) {
            $rewardsType[] = RewardTypeEnum::from($reward->getRewardType() ?? 1)->name;
        }

        return array_unique($rewardsType);
    }

    public function getRewardsCount(): ?int
    {
        return count($this->getLoyalityRewards());
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

    public function getHolder(): ?User
    {
        return $this->holder;
    }

    public function setHolder(?User $holder): self
    {
        // unset the owning side of the relation if necessary
        if (null === $holder && null !== $this->holder) {
            $this->holder->setLoyalityCard(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $holder && $holder->getLoyalityCard() !== $this) {
            $holder->setLoyalityCard($this);
        }

        $this->holder = $holder;

        return $this;
    }

    public function getPreviousCardType(): ?int
    {
        return $this->previous_card_type;
    }

    public function setPreviousCardType(int $previous_card_type): self
    {
        $this->previous_card_type = $previous_card_type;

        return $this;
    }

    #[Orm\PrePersist]
    public function setPreviousCardTypeValue(): void
    {
        $this->previous_card_type = LoyalityCardTypeEnum::Silver->value;
    }
}
