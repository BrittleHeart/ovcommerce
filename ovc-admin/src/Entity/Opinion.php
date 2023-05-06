<?php

namespace App\Entity;

use App\Enum\OpinionProductRateEnum;
use App\Repository\OpinionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpinionRepository::class)]
class Opinion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'opinions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $by_user = null;

    #[ORM\ManyToOne(inversedBy: 'opinions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $product_rate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $product_comment = null;

    #[ORM\Column]
    private ?bool $is_approved = null;

    public function __toString(): string
    {
        if (!is_int($this->getProductRate())) {
            return "{$this->getByUser()} []";
        }

        $rate = OpinionProductRateEnum::from($this->getProductRate())->name;
        return "{$this->getByUser()} [$rate]";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getByUser(): ?User
    {
        return $this->by_user;
    }

    public function setByUser(?User $by_user): self
    {
        $this->by_user = $by_user;

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

    public function getProductRate(): ?int
    {
        return $this->product_rate;
    }

    public function setProductRate(int $product_rate): self
    {
        $this->product_rate = $product_rate;

        return $this;
    }

    public function getProductComment(): ?string
    {
        return $this->product_comment;
    }

    public function setProductComment(?string $product_comment): self
    {
        $this->product_comment = $product_comment;

        return $this;
    }

    public function isIsApproved(): ?bool
    {
        return $this->is_approved;
    }

    public function setIsApproved(bool $is_approved): self
    {
        $this->is_approved = $is_approved;

        return $this;
    }
}
