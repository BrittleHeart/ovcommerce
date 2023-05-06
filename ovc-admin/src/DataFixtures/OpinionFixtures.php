<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use App\Entity\Product;
use App\Entity\User;
use App\Enum\OpinionProductRateEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class OpinionFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
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

        $product = $this->getReference(ProductFixtures::PRODUCT_SAMPLE_REF);
        if (!$product instanceof Product) {
            return;
        }

        $opinion = new Opinion();
        $opinion->setByUser($user);
        $opinion->setProduct($product);
        $opinion->setIsApproved(true);
        $opinion->setProductComment($this->faker->realText());
        $opinion->setProductRate(OpinionProductRateEnum::Amazing->value);

        $manager->persist($opinion);
        $manager->flush();
    }

    /**
     * @return array<array-key, string>
     */
    public static function getGroups(): array
    {
        return ['product', 'user'];
    }

    /**
     * @return array<array-key, class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            UserFixtures::class,
        ];
    }
}
