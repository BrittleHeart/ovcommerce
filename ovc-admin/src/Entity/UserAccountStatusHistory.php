<?php

namespace App\Entity;

use App\Enum\UserAccountActionEnum;
use App\Repository\UserAccountStatusHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAccountStatusHistoryRepository::class)]
class UserAccountStatusHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userAccountStatusHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $for_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $operator = null;

    #[ORM\Column(enumType: UserAccountActionEnum::class)]
    private ?int $action = null;

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

    public function getOperator(): ?User
    {
        return $this->operator;
    }

    public function setOperator(?User $operator): self
    {
        $this->operator = $operator;

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
