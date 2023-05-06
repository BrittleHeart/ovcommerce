<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Enum\ProductAvailableOnEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProductFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private Generator $faker;
    public const PRODUCT_SAMPLE_REF = 'product_sample';

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $category = $this->getReference(CategoryFixtures::PRODUCT_CATEGORY_REF);
        if (!$category instanceof Category) {
            return;
        }

        $product = new Product();
        $product->setName('Słuchawki Samsung Xi12');
        $product->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tellus urna, convallis quis justo at, dignissim aliquet leo. ');
        $product->setIsOnSale(false);
        $product->setPoints(100);
        $product->setQuantity(1000);
        $product->setPrice('429.99');
        $product->setAvailableOn(ProductAvailableOnEnum::Both->value);
        $product->setCategory($category);
        $product->setUuid($this->faker->uuid());
        $product->setCoverUrl($this->faker->imageUrl());
        $product->setBackgroundUrl($this->faker->imageUrl());

        $manager->persist($product);
        $manager->flush();

        $this->addReference(self::PRODUCT_SAMPLE_REF, $product);
    }

    /**
     * @return array<array-key, string>
     */
    public static function getGroups(): array
    {
        return ['product'];
    }

    /**
     * @return array<array-key, class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
