<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    description: 'Product',
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'product:collection']),
        new Get(normalizationContext: ['groups' => 'product:item']),
    ],
    stateless: true
)]
#[ApiFilter(DateFilter::class, properties: ['created_at', 'updated_at'])]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact', 'description' => 'partial', 'price' => 'partial'])]
#[ApiFilter(BooleanFilter::class, properties: ['is_on_sale'])]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ApiProperty(readable: false, identifier: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(identifier: true)]
    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column]
    private ?string $uuid = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(length: 100, unique: true)]
    private ?string $name = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $price = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column]
    private ?int $quantity = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(length: 255)]
    private ?string $cover_url = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(length: 255)]
    private ?string $background_url = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $merged_url = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column(options: ['default' => false])]
    private ?bool $is_on_sale = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column]
    private ?int $points = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column]
    private ?int $available_on = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[Groups(['product:collection', 'product:item'])]
    #[ORM\Column]
    private ?\DateTime $updated_at = null;

    #[Groups(['product:item'])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var ArrayCollection<int, OrderItem> $orderItems
     */
    #[Groups(['product:item'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    /**
     * @var ArrayCollection<int, UserFavorite> $userFavorites
     */
    #[Groups(['product:item'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: UserFavorite::class)]
    private Collection $userFavorites;

    /**
     * @var ArrayCollection<int, UserProductOrderPointHistory> $userProductOrderPointHistories
     */
    #[Groups(['product:item'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: UserProductOrderPointHistory::class)]
    private Collection $userProductOrderPointHistories;

    #[Groups(['product:item'])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Coupon $coupon = null;

    /**
     * @var ArrayCollection<int, Opinion> $opinions
     */
    #[Groups(['product:item'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Opinion::class)]
    private Collection $opinions;

    /**
     * @var ArrayCollection<int, VisitedUrl> $visitedUrls
     */
    #[Groups(['product:item'])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: VisitedUrl::class)]
    private Collection $visitedUrls;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->userFavorites = new ArrayCollection();
        $this->userProductOrderPointHistories = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->visitedUrls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    #[ORM\PrePersist]
    public function setUuidValue(): void
    {
        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->cover_url;
    }

    public function setCoverUrl(string $cover_url): self
    {
        $this->cover_url = $cover_url;

        return $this;
    }

    public function getBackgroundUrl(): ?string
    {
        return $this->background_url;
    }

    public function setBackgroundUrl(string $background_url): self
    {
        $this->background_url = $background_url;

        return $this;
    }

    public function getMergedUrl(): ?string
    {
        return $this->merged_url;
    }

    public function setMergedUrl(string $merged_url): self
    {
        $this->merged_url = $merged_url;

        return $this;
    }

    public function isIsOnSale(): ?bool
    {
        return $this->is_on_sale;
    }

    public function setIsOnSale(bool $is_on_sale): self
    {
        $this->is_on_sale = $is_on_sale;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getAvailableOn(): ?int
    {
        return $this->available_on;
    }

    public function setAvailableOn(int $available_on): self
    {
        $this->available_on = $available_on;

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

    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @throws \Exception
     */
    #[ORM\PrePersist]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setProduct($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getProduct() === $this) {
                $orderItem->setProduct(null);
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
            $userFavorite->setProduct($this);
        }

        return $this;
    }

    public function removeUserFavorite(UserFavorite $userFavorite): self
    {
        if ($this->userFavorites->removeElement($userFavorite)) {
            // set the owning side to null (unless already changed)
            if ($userFavorite->getProduct() === $this) {
                $userFavorite->setProduct(null);
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
            $userProductOrderPointHistory->setProduct($this);
        }

        return $this;
    }

    public function removeUserProductOrderPointHistory(UserProductOrderPointHistory $userProductOrderPointHistory): self
    {
        if ($this->userProductOrderPointHistories->removeElement($userProductOrderPointHistory)) {
            // set the owning side to null (unless already changed)
            if ($userProductOrderPointHistory->getProduct() === $this) {
                $userProductOrderPointHistory->setProduct(null);
            }
        }

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

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
            $opinion->setProduct($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getProduct() === $this) {
                $opinion->setProduct(null);
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
            $visitedUrl->setProduct($this);
        }

        return $this;
    }

    public function removeVisitedUrl(VisitedUrl $visitedUrl): self
    {
        if ($this->visitedUrls->removeElement($visitedUrl)) {
            // set the owning side to null (unless already changed)
            if ($visitedUrl->getProduct() === $this) {
                $visitedUrl->setProduct(null);
            }
        }

        return $this;
    }
}
