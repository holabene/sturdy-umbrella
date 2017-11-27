<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserDataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $user = new \SturdyUmbrella\Entity\User();
            $user->setName($faker->firstName.' '.$faker->lastName);
            $user->setUsername($faker->unique()->word.'@'.$faker->freeEmailDomain);
            $user->setPassword($faker->password);

            $manager->persist($user);
            $manager->flush();
        }
    }
}

class UserFriendsDataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $repository = $manager->getRepository(\SturdyUmbrella\Entity\User::class);
        $users = $repository->findAll();

        /** @var \SturdyUmbrella\Entity\User $user */
        foreach ($users as $user) {
            for ($i = 0; $i < rand(0, 20); $i++) {
                $friend = $users[rand(0, count($users)-1)];
                if ($friend !== $user) {
                    $user->addFriend($friend);
                }
            }

            $manager->persist($user);
            $manager->flush();
        }
    }
}
