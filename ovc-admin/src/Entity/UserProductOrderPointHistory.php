<?php

namespace App\Entity;

use App\Repository\UserProductOrderPointHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProductOrderPointHistoryRepository::class)]
class UserProductOrderPointHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userProductOrderPointHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $for_user = null;

    #[ORM\ManyToOne(inversedBy: 'userProductOrderPointHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'userProductOrderPointHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserOrder $for_order = null;

    #[ORM\Column]
    private ?int $points_earned = null;

    #[ORM\Column(options: ['default' => 'now()'])]
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getForOrder(): ?UserOrder
    {
        return $this->for_order;
    }

    public function setForOrder(?UserOrder $for_order): self
    {
        $this->for_order = $for_order;

        return $this;
    }

    public function getPointsEarned(): ?int
    {
        return $this->points_earned;
    }

    public function setPointsEarned(int $points_earned): self
    {
        $this->points_earned = $points_earned;

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
