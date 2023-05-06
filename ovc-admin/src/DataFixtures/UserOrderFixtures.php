<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Entity\UserOrder;
use App\Entity\UserPayment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserOrderFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public const USER_ORDER_REF = 'user_order';

    public function load(ObjectManager $manager): void
    {
        $user = $this->getReference(UserFixtures::ADMIN_USER_REFERENCE);
        if (!$user instanceof User) {
            return;
        }

        $payment = $this->getReference(UserPaymentFixtures::ADMIN_PAYMENT_REF);
        if (!$payment instanceof UserPayment) {
            return;
        }

        $shipping = $this->getReference(UserAddressFixtures::USER_ADDRESS_REF);
        if (!$shipping instanceof UserAddress) {
            return;
        }

        $userOrder = new UserOrder();
        $userOrder->setByUser($user);
        $userOrder->setOrderDate(new \DateTimeImmutable());
        $userOrder->setPaymentMethod($payment);
        $userOrder->setShippingAddress($shipping);
        $userOrder->setTotalPrice('333');

        $manager->persist($userOrder);
        $manager->flush();

        $this->addReference(self::USER_ORDER_REF, $userOrder);
    }

    /**
     * @return array<array-key, string>
     */
    public static function getGroups(): array
    {
        return ['order', 'user'];
    }

    /**
     * @return array<array-key, class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            UserPaymentFixtures::class,
            UserAddressFixtures::class,
        ];
    }
}
