<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    description: 'Categories',
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'category:collection']),
        new Get(normalizationContext: ['groups' => 'category:item']),
    ],
    stateless: true
)]
#[HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:collection', 'category:item'])]
    private ?int $id = null;

    #[Groups(['category:collection', 'category:item'])]
    #[ORM\Column(length: 45, unique: true)]
    private ?string $name = null;

    #[Groups(['category:collection', 'category:item'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[Groups(['category:collection', 'category:item'])]
    #[ORM\Column]
    private ?\DateTime $updated_at = null;

    /**
     * @var ArrayCollection<int, Product> $products
     */
    #[Groups(['category:item'])]
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @psalm-suppress InvalidToString
     * @psalm-suppress NullableReturnStatement
     */
    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
}
