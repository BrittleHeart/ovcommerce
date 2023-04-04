<?php

namespace App\Entity;

use App\Enum\LoyalityCardTypeEnum;
use App\Repository\LoyalityCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    public function __construct()
    {
        $this->for_user = new ArrayCollection();
        $this->loyalityPoints = new ArrayCollection();
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
}
