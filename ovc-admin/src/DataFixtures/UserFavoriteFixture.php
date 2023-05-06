<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\UserFavorite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFavoriteFixture extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
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

        $favorite = new UserFavorite();
        $favorite->setByUser($user);
        $favorite->setProduct($product);
        $favorite->setLikedAt(new \DateTimeImmutable());
        $favorite->setDislikedAt(null);

        $manager->persist($favorite);
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
            UserFixtures::class,
            ProductFixtures::class,
        ];
    }
}
