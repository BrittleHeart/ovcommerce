<?php

namespace App\Entity;

use App\Enum\UserPaymentTypeEnum;
use App\Repository\UserPaymentHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserPaymentHistoryRepository::class)]
class UserPaymentHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userPaymentHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $for_user = null;

    #[ORM\Column]
    private ?int $payment_method_status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @psalm-suppress InvalidToString
     * @psalm-suppress NullableReturnStatement
     */
    public function __toString(): string
    {
        $paymentStatus = UserPaymentTypeEnum::from($this->getPaymentMethodStatus() ?? 1)->name;

        return "{$this->getForUser()} [$paymentStatus]";
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

    public function getPaymentMethodStatus(): ?int
    {
        return $this->payment_method_status;
    }

    public function setPaymentMethodStatus(int $payment_method_status): self
    {
        $this->payment_method_status = $payment_method_status;

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
}
