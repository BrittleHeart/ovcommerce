<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\UserAccountStatusEnum;
use App\Enum\UserRolesEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private Generator $faker;

    public const ADMIN_USER_REFERENCE = 'admin';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->createAdmin($manager);

        $statusAvailable = [
            UserAccountStatusEnum::Open->value,
            UserAccountStatusEnum::Blocked->value,
            UserAccountStatusEnum::TemporamentlyClosed->value,
            UserAccountStatusEnum::EmailNotVerified->value,
        ];

        for ($i = 0; $i <= 10; ++$i) {
            /** @var int $status */
            $status = $this->faker->randomElement($statusAvailable);

            $user = new User();
            $user->setUuid($this->faker->unique()->uuid());
            $user->setUsername($this->faker->unique()->userName());
            $user->setEmail($this->faker->email());
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            $user->setStatus($status);
            $user->setRoles([
                UserRolesEnum::User->value,
            ]);
            $user->setIsEmailVerified(UserAccountStatusEnum::EmailNotVerified->value !== $status);
            $user->setLastLogin(new \DateTime());
            $manager->persist($user);
            $manager->flush();
        }
    }

    private function createAdmin(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUuid($this->faker->unique()->uuid());
        $user->setUsername('Admin');
        $user->setEmail('admin@example.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($hashedPassword);
        $user->setStatus(
            UserAccountStatusEnum::Open->value
        );
        $user->setRoles([
            UserRolesEnum::Admin->value,
        ]);
        $user->setIsEmailVerified(true);
        $user->setLastLogin(new \DateTime());
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
