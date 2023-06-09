<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Enum\CountryEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserAddressFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public const USER_ADDRESS_REF = 'ADMIN_USER_ADDRESS';
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

        $address = new UserAddress();
        $address->setAddress1($this->faker->address());
        $address->setForUser($user);
        $address->setCity($this->faker->city());
        $address->setCountry(CountryEnum::Poland->value);
        $address->setFirstName($this->faker->firstNameMale());
        $address->setLastName($this->faker->lastName());
        $address->setPostalCode($this->faker->postcode());
        $this->addReference(self::USER_ADDRESS_REF, $address);

        $manager->persist($address);
        $manager->flush();
    }

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
