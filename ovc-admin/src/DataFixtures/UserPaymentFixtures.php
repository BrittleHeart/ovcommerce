<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserPayment;
use App\Enum\UserPaymentStatusEnum;
use App\Enum\UserPaymentTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserPaymentFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->getReference(UserFixtures::ADMIN_USER_REFERENCE);
        if (!$user instanceof User) {
            return;
        }

        $payment = new UserPayment();
        $payment->setForUser($user);
        $payment->setStatus(UserPaymentStatusEnum::Accepted->value);
        $payment->setPaymentType(UserPaymentTypeEnum::CreditCard->value);
        $payment->setCardExpirationDay((new \DateTime())->add(new \DateInterval('P1Y')));
        $payment->setCardholderName($this->faker->firstNameMale());
        $payment->setCardNumber($this->faker->creditCardNumber());

        $manager->persist($payment);
        $manager->flush();
    }

    /**
     * @return array<array-key, string>
     */
    public static function getGroups(): array
    {
        return ['user'];
    }

    /**
     * @return array<array-key, class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
