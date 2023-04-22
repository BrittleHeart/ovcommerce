<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\UserAccountStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    description: 'User resource',
    operations: [
        new Get(normalizationContext: ['groups' => 'user:item']),
        new Post(normalizationContext: ['groups' => 'user:new']),
        new Patch(normalizationContext: ['groups' => 'user:update']),
        new Delete(normalizationContext: ['groups' => 'user:delete']),
    ],
    stateless: true
)]
#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ApiProperty(readable: false, identifier: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:update', 'user:delete'])]
    private ?int $id = null;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    #[Groups(['user:item', 'user:new', 'user:delete'])]
    private ?string $uuid = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:item', 'user:new'])]
    private ?string $email = null;

    /**
     * @var array<array-key, string>
     */
    #[ORM\Column]
    #[Groups(['user:item'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:new', 'user:update'])]
    private ?string $password = null;

    #[ORM\Column(length: 30, unique: true)]
    #[Groups(['user:item', 'user:new'])]
    private ?string $username = null;

    #[ORM\Column(
        options: [
            'default' => UserAccountStatusEnum::EmailNotVerified->value,
        ]
    )]
    #[Groups(['user:item', 'user:update'])]
    #[NotBlank]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['user:item', 'user:update'])]
    private ?\DateTimeInterface $last_login = null;

    #[ORM\Column(options: ['default' => false])]
    #[Groups(['user:item', 'user:update'])]
    private ?bool $is_email_verified = null;

    #[ORM\Column(options: ['default' => 'now()'])]
    #[Groups(['user:item', 'user:new'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(
        type: Types::DATE_MUTABLE,
        options: ['default' => 'now()']
    )]
    #[NotBlank]
    #[Groups(['user:item', 'user:update', 'user:new'])]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var ArrayCollection<int, UserAddress> $userAddresses
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserAddress::class)]
    private Collection $userAddresses;

    /**
     * @var ArrayCollection<int, UserPayment> $userPayments
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserPayment::class)]
    private Collection $userPayments;

    /**
     * @var ArrayCollection<int, UserAddressHistory> $userAddressHistories
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserAddressHistory::class)]
    private Collection $userAddressHistories;

    /**
     * @var ArrayCollection<int, UserAccountStatusHistory> $userAccountStatusHistories
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserAccountStatusHistory::class)]
    private Collection $userAccountStatusHistories;

    /**
     * @var ArrayCollection<int, UserOrder> $userOrders
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'by_user', targetEntity: UserOrder::class)]
    private Collection $userOrders;

    /**
     * @var ArrayCollection<int, UserFavorite> $userFavorites
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'by_user', targetEntity: UserFavorite::class)]
    private Collection $userFavorites;

    /**
     * @var ArrayCollection<int, UserProductOrderPointHistory> $userProductOrderPointHistories
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserProductOrderPointHistory::class)]
    private Collection $userProductOrderPointHistories;

    /**
     * @var ArrayCollection<int, Opinion> $opinions
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'by_user', targetEntity: Opinion::class)]
    private Collection $opinions;

    /**
     * @var ArrayCollection<int, VisitedUrl> $visitedUrls
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'by_user', targetEntity: VisitedUrl::class)]
    private Collection $visitedUrls;

    /**
     * @var ArrayCollection<int, UserCardRankingHistory> $userCardRankingHistories
     */
    #[Groups(['user:item', 'user:new', 'user:update', 'user:delete'])]
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserCardRankingHistory::class)]
    private Collection $userCardRankingHistories;

    #[ORM\OneToOne(inversedBy: 'holder', cascade: ['persist', 'remove'])]
    private ?LoyalityCard $loyality_card = null;

    /**
     * @var ArrayCollection<int, UserPaymentHistory> $userPaymentHistories
     */
    #[ORM\OneToMany(mappedBy: 'for_user', targetEntity: UserPaymentHistory::class)]
    private Collection $userPaymentHistories;

    public function __construct()
    {
        $this->userAddresses = new ArrayCollection();
        $this->userPayments = new ArrayCollection();
        $this->userAddressHistories = new ArrayCollection();
        $this->userAccountStatusHistories = new ArrayCollection();
        $this->userOrders = new ArrayCollection();
        $this->userFavorites = new ArrayCollection();
        $this->userProductOrderPointHistories = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->visitedUrls = new ArrayCollection();
        $this->userCardRankingHistories = new ArrayCollection();
        $this->userPaymentHistories = new ArrayCollection();
    }

    /**
     * @psalm-suppress InvalidToString
     * @psalm-suppress NullableReturnStatement
     */
    public function __toString(): string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<array-key, string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getusername(): ?string
    {
        return $this->username;
    }

    public function setusername(string $username): self
    {
        $this->username = $username;

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

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }

    public function isIsEmailVerified(): ?bool
    {
        return $this->is_email_verified;
    }

    public function setIsEmailVerified(bool $is_email_verified): self
    {
        $this->is_email_verified = $is_email_verified;

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
    public function setCreatedAtValue(): self
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
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
    public function setUpdatedAtValue(): self
    {
        $this->updated_at = new \DateTime();

        return $this;
    }

    /**
     * @return Collection<int, UserAddress>
     */
    public function getUserAddresses(): Collection
    {
        return $this->userAddresses;
    }

    public function addUserAddress(UserAddress $userAddress): self
    {
        if (!$this->userAddresses->contains($userAddress)) {
            $this->userAddresses->add($userAddress);
            $userAddress->setForUser($this);
        }

        return $this;
    }

    public function removeUserAddress(UserAddress $userAddress): self
    {
        if ($this->userAddresses->removeElement($userAddress)) {
            // set the owning side to null (unless already changed)
            if ($userAddress->getForUser() === $this) {
                $userAddress->setForUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPayment>
     */
    public function getUserPayments(): Collection
    {
        return $this->userPayments;
    }

    public function addUserPayment(UserPayment $userPayment): self
    {
        if (!$this->userPayments->contains($userPayment)) {
            $this->userPayments->add($userPayment);
            $userPayment->setForUser($this);
        }

        return $this;
    }

    public function removeUserPayment(UserPayment $userPayment): self
    {
        if ($this->userPayments->removeElement($userPayment)) {
            // set the owning side to null (unless already changed)
            if ($userPayment->getForUser() === $this) {
                $userPayment->setForUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAddressHistory>
     */
    public function getUserAddressHistories(): Collection
    {
        return $this->userAddressHistories;
    }

    public function addUserAddressHistory(UserAddressHistory $userAddressHistory): self
    {
        if (!$this->userAddressHistories->contains($userAddressHistory)) {
            $this->userAddressHistories->add($userAddressHistory);
            $userAddressHistory->setForUser($this);
        }

        return $this;
    }

    public function removeUserAddressHistory(UserAddressHistory $userAddressHistory): self
    {
        if ($this->userAddressHistories->removeElement($userAddressHistory)) {
            // set the owning side to null (unless already changed)
            if ($userAddressHistory->getForUser() === $this) {
                $userAddressHistory->setForUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAccountStatusHistory>
     */
    public function getUserAccountStatusHistories(): Collection
    {
        return $this->userAccountStatusHistories;
    }

    public function addUserAccountStatusHistory(UserAccountStatusHistory $userAccountStatusHistory): self
    {
        if (!$this->userAccountStatusHistories->contains($userAccountStatusHistory)) {
            $this->userAccountStatusHistories->add($userAccountStatusHistory);
            $userAccountStatusHistory->setForUser($this);
        }

        return $this;
    }

    public function removeUserAccountStatusHistory(UserAccountStatusHistory $userAccountStatusHistory): self
    {
        if ($this->userAccountStatusHistories->removeElement($userAccountStatusHistory)) {
            // set the owning side to null (unless already changed)
            if ($userAccountStatusHistory->getForUser() === $this) {
                $userAccountStatusHistory->setForUser(null);
            }
        }

        return $this;
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
            $userOrder->setByUser($this);
        }

        return $this;
    }

    public function removeUserOrder(UserOrder $userOrder): self
    {
        if ($this->userOrders->removeElement($userOrder)) {
            // set the owning side to null (unless already changed)
            if ($userOrder->getByUser() === $this) {
                $userOrder->setByUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserFavorite>
     */
    public function getUserFavorites(): Collection
    {
        return $this->userFavorites;
    }

    public function addUserFavorite(UserFavorite $userFavorite): self
    {
        if (!$this->userFavorites->contains($userFavorite)) {
            $this->userFavorites->add($userFavorite);
            $userFavorite->setByUser($this);
        }

        return $this;
    }

    public function removeUserFavorite(UserFavorite $userFavorite): self
    {
        if ($this->userFavorites->removeElement($userFavorite)) {
            // set the owning side to null (unless already changed)
            if ($userFavorite->getByUser() === $this) {
                $userFavorite->setByUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserProductOrderPointHistory>
     */
    public function getUserProductOrderPointHistories(): Collection
    {
        return $this->userProductOrderPointHistories;
    }

    public function addUserProductOrderPointHistory(UserProductOrderPointHistory $userProductOrderPointHistory): self
    {
        if (!$this->userProductOrderPointHistories->contains($userProductOrderPointHistory)) {
            $this->userProductOrderPointHistories->add($userProductOrderPointHistory);
            $userProductOrderPointHistory->setForUser($this);
        }

        return $this;
    }

    public function removeUserProductOrderPointHistory(UserProductOrderPointHistory $userProductOrderPointHistory): self
    {
        if ($this->userProductOrderPointHistories->removeElement($userProductOrderPointHistory)) {
            // set the owning side to null (unless already changed)
            if ($userProductOrderPointHistory->getForUser() === $this) {
                $userProductOrderPointHistory->setForUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Opinion>
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions->add($opinion);
            $opinion->setByUser($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getByUser() === $this) {
                $opinion->setByUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VisitedUrl>
     */
    public function getVisitedUrls(): Collection
    {
        return $this->visitedUrls;
    }

    public function addVisitedUrl(VisitedUrl $visitedUrl): self
    {
        if (!$this->visitedUrls->contains($visitedUrl)) {
            $this->visitedUrls->add($visitedUrl);
            $visitedUrl->setByUser($this);
        }

        return $this;
    }

    public function removeVisitedUrl(VisitedUrl $visitedUrl): self
    {
        if ($this->visitedUrls->removeElement($visitedUrl)) {
            // set the owning side to null (unless already changed)
            if ($visitedUrl->getByUser() === $this) {
                $visitedUrl->setByUser(null);
            }
        }

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
            $userCardRankingHistory->setForUser($this);
        }

        return $this;
    }

    public function removeUserCardRankingHistory(UserCardRankingHistory $userCardRankingHistory): self
    {
        if ($this->userCardRankingHistories->removeElement($userCardRankingHistory)) {
            // set the owning side to null (unless already changed)
            if ($userCardRankingHistory->getForUser() === $this) {
                $userCardRankingHistory->setForUser(null);
            }
        }

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getLoyalityCard(): ?LoyalityCard
    {
        return $this->loyality_card;
    }

    public function setLoyalityCard(?LoyalityCard $loyality_card): self
    {
        $this->loyality_card = $loyality_card;

        return $this;
    }

    /**
     * @return Collection<int, UserPaymentHistory>
     */
    public function getUserPaymentHistories(): Collection
    {
        return $this->userPaymentHistories;
    }

    public function addUserPaymentHistory(UserPaymentHistory $userPaymentHistory): self
    {
        if (!$this->userPaymentHistories->contains($userPaymentHistory)) {
            $this->userPaymentHistories->add($userPaymentHistory);
            $userPaymentHistory->setForUser($this);
        }

        return $this;
    }

    public function removeUserPaymentHistory(UserPaymentHistory $userPaymentHistory): self
    {
        if ($this->userPaymentHistories->removeElement($userPaymentHistory)) {
            // set the owning side to null (unless already changed)
            if ($userPaymentHistory->getForUser() === $this) {
                $userPaymentHistory->setForUser(null);
            }
        }

        return $this;
    }
}
