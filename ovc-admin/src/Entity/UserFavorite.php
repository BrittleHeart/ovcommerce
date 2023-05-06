<?php

namespace App\Entity;

use App\Repository\UserFavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserFavoriteRepository::class)]
class UserFavorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userFavorites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $by_user = null;

    #[ORM\ManyToOne(inversedBy: 'userFavorites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $liked_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $disliked_at = null;

    public function __toString(): string
    {
        $favoriteProduct = $this->getProduct();
        if (null === $favoriteProduct) {
            throw new \LogicException('User favorite cannot have nullable product');
        }

        return "{$this->getByUser()} [{$favoriteProduct->getName()}]";
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

    public function getLikedAt(): ?\DateTimeImmutable
    {
        return $this->liked_at;
    }

    public function setLikedAt(\DateTimeImmutable $liked_at): self
    {
        $this->liked_at = $liked_at;

        return $this;
    }

    public function getDislikedAt(): ?\DateTimeImmutable
    {
        return $this->disliked_at;
    }

    public function setDislikedAt(?\DateTimeImmutable $disliked_at): self
    {
        $this->disliked_at = $disliked_at;

        return $this;
    }
}
