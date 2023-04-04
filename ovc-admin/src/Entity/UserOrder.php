<?php

namespace App\Entity;

use App\Repository\UserOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserOrderRepository::class)]
class UserOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $by_user = null;

    #[ORM\ManyToOne(inversedBy: 'userOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAddress $shipping_address = null;

    #[ORM\ManyToOne(inversedBy: 'userOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserPayment $payment_method = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $order_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $total_price = null;

    #[ORM\Column(options: ['default' => 'now()'])]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var ArrayCollection<int, OrderItem> $orderItems
     */
    #[ORM\OneToMany(mappedBy: 'for_order', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    /**
     * @var ArrayCollection<int, UserProductOrderPointHistory> $userProductOrderPointHistories
     */
    #[ORM\OneToMany(mappedBy: 'for_order', targetEntity: UserProductOrderPointHistory::class)]
    private Collection $userProductOrderPointHistories;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->userProductOrderPointHistories = new ArrayCollection();
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

    public function getShippingAddress(): ?UserAddress
    {
        return $this->shipping_address;
    }

    public function setShippingAddress(?UserAddress $shipping_address): self
    {
        $this->shipping_address = $shipping_address;

        return $this;
    }

    public function getPaymentMethod(): ?UserPayment
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(?UserPayment $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeImmutable
    {
        return $this->order_date;
    }

    public function setOrderDate(\DateTimeImmutable $order_date): self
    {
        $this->order_date = $order_date;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->total_price;
    }

    public function setTotalPrice(string $total_price): self
    {
        $this->total_price = $total_price;

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
            $orderItem->setForOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getForOrder() === $this) {
                $orderItem->setForOrder(null);
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
            $userProductOrderPointHistory->setForOrder($this);
        }

        return $this;
    }

    public function removeUserProductOrderPointHistory(UserProductOrderPointHistory $userProductOrderPointHistory): self
    {
        if ($this->userProductOrderPointHistories->removeElement($userProductOrderPointHistory)) {
            // set the owning side to null (unless already changed)
            if ($userProductOrderPointHistory->getForOrder() === $this) {
                $userProductOrderPointHistory->setForOrder(null);
            }
        }

        return $this;
    }
}
