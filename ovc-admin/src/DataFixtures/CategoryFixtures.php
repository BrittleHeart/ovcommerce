<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    private Generator $faker;
    public const PRODUCT_CATEGORY_REF = 'product_sample_category';

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Technology',
            'Business',
            'Beauty',
            'Electronics',
            'Automotive',
            'Spa & Wellness',
            'Garden & Home',
            'Outdoor & Sport',
        ];

        $category = new Category();
        $category->setName((string) $this->faker->randomElement($categories));

        $manager->persist($category);
        $manager->flush();

        $this->addReference(self::PRODUCT_CATEGORY_REF, $category);
    }

    /**
     * @return array<array-key, string>
     */
    public static function getGroups(): array
    {
        return ['product'];
    }
}
