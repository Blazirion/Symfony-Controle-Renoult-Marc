<?php

namespace App\DataFixtures;

use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use Faker\Factory as Faker;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        $createdAt = \DateTimeImmutable::createFromMutable($faker->datetime());
        $updatedAt = \DateTimeImmutable::createFromMutable($faker->datetime());
        $users = $this->userRepository->findAll();
        $usersLength = count($users)-1;
        for ($i=0; $i < 100; $i++) {
            $randomKey = rand(0, $usersLength);
            $user = $users[$randomKey];
            $post = new Post();
            $post->setAuthor($user);
            $post
                ->setTitle($faker->words(3, true))
                ->setAuthor($user)
                ->setImage($faker->imageUrl) // un petit oubli
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt)
            ;
            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
