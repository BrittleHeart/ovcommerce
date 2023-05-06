<?php

namespace App\DataFixtures;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\UserOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $product = $this->getReference(ProductFixtures::PRODUCT_SAMPLE_REF);
        if (!$product instanceof Product) {
            return;
        }

        $userOrder = $this->getReference(UserOrderFixtures::USER_ORDER_REF);
        if (!$userOrder instanceof UserOrder) {
            return;
        }

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setForOrder($userOrder);
        $orderItem->setQuantity(5);
        $orderItem->setPrice('10000');

        $manager->persist($orderItem);
        $manager->flush();
    }

    /**
     * @return array<array-key, string>
     */
    public static function getGroups(): array
    {
        return [''];
    }

    /**
     * @return array<array-key, class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            UserOrderFixtures::class,
        ];
    }
}
