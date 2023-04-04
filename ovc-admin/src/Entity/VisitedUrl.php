<?php

namespace App\Entity;

use App\Repository\VisitedUrlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitedUrlRepository::class)]
class VisitedUrl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visitedUrls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $by_user = null;

    #[ORM\ManyToOne(inversedBy: 'visitedUrls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    private ?string $url_token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $visited_at = null;

    #[ORM\Column(options: ['default' => 'now()'])]
    private ?\DateTimeImmutable $created_at = null;

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

    public function getUrlToken(): ?string
    {
        return $this->url_token;
    }

    public function setUrlToken(string $url_token): self
    {
        $this->url_token = $url_token;

        return $this;
    }

    public function getVisitedAt(): ?\DateTimeImmutable
    {
        return $this->visited_at;
    }

    public function setVisitedAt(\DateTimeImmutable $visited_at): self
    {
        $this->visited_at = $visited_at;

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
