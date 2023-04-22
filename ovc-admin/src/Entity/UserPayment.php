<?php

namespace App\Entity;

use App\Enum\UserPaymentTypeEnum;
use App\Repository\UserPaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserPaymentRepository::class)]
class UserPayment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userPayments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $for_user = null;

    #[ORM\Column]
    private ?int $payment_type = null;

    #[ORM\Column(length: 16, unique: true, nullable: true)]
    private ?string $card_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cardholder_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $card_expiration_day = null;

    /**
     * @var ArrayCollection<int, UserAddress> $billing_address
     */
    #[ORM\ManyToMany(targetEntity: UserAddress::class, inversedBy: 'userPayments')]
    private Collection $billing_address;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(
        options: ['default' => 'now()'],
    )]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(
        type: Types::DATE_MUTABLE,
        options: ['default' => 'now()']
    )]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var ArrayCollection<int, UserOrder> $userOrders
     */
    #[ORM\OneToMany(mappedBy: 'payment_method', targetEntity: UserOrder::class)]
    private Collection $userOrders;

    public function __construct()
    {
        $this->billing_address = new ArrayCollection();
        $this->userOrders = new ArrayCollection();
    }

    /**
     * @psalm-suppress InvalidToString
     * @psalm-suppress NullableReturnStatement
     */
    public function __toString(): string
    {
        $paymentType = UserPaymentTypeEnum::from($this->getPaymentType() ?? 1)->name;

        return "{$this->getForUser()} [$paymentType]";
    }

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

    public function getPaymentType(): ?int
    {
        return $this->payment_type;
    }

    public function setPaymentType(int $payment_type): self
    {
        $this->payment_type = $payment_type;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    public function setCardNumber(?string $card_number): self
    {
        $this->card_number = $card_number;

        return $this;
    }

    public function getCardholderName(): ?string
    {
        return $this->cardholder_name;
    }

    public function setCardholderName(?string $cardholder_name): self
    {
        $this->cardholder_name = $cardholder_name;

        return $this;
    }

    public function getCardExpirationDay(): ?\DateTimeInterface
    {
        return $this->card_expiration_day;
    }

    public function setCardExpirationDay(?\DateTimeInterface $card_expiration_day): self
    {
        $this->card_expiration_day = $card_expiration_day;

        return $this;
    }

    /**
     * @return Collection<int, UserAddress>
     */
    public function getBillingAddress(): Collection
    {
        return $this->billing_address;
    }

    public function addBillingAddress(UserAddress $billingAddress): self
    {
        if (!$this->billing_address->contains($billingAddress)) {
            $this->billing_address->add($billingAddress);
        }

        return $this;
    }

    public function removeBillingAddress(UserAddress $billingAddress): self
    {
        $this->billing_address->removeElement($billingAddress);

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, UserOrder>
     */
    public function getUserOrders(): Collection
    {
        return $this->userOrders;
    }

    public function addUserOrder(UserOrder $userOrder): self
    {
        if (!$this->userOrders->contains($userOrder)) {
            $this->userOrders->add($userOrder);
            $userOrder->setPaymentMethod($this);
        }

        return $this;
    }

    public function removeUserOrder(UserOrder $userOrder): self
    {
        if ($this->userOrders->removeElement($userOrder)) {
            // set the owning side to null (unless already changed)
            if ($userOrder->getPaymentMethod() === $this) {
                $userOrder->setPaymentMethod(null);
            }
        }

        return $this;
    }
}
