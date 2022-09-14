<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create("fr_FR");
        $this->loadUsers($manager, $faker);
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager, FakerGenerator $faker): void
    {
        $userDatas = [
            [
                "email" => "admin@exemple.com",
                "roles" => "[ROLE_ADMIN]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00')
            ],

            [
                "email" => "foo.foo@exemple.com",
                "roles" => "[ROLE_EMPRUNTEUR]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00')
            ],

            [
                "email" => "bar.bar@exemple.com",
                "roles" => "[ROLE_EMPRUNTEUR]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => false,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 11:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-05-01 12:00:00')
            ],

            [
                "email" => "baz.baz@exemple.com",
                "roles" => "[ROLE_EMPRUNTEUR]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00')
            ]
        ];
        
        foreach ($userDatas as $userData){
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData["roles"]);
            $user->setPassword($userData['password']);
            $user->setEnabled($userData['enabled']);
            $user->setCreatedAt($userData['created_at']);
            $user->setUpdatedAt($userData['updated_at']);

            $manager->persist($user);
        }

        for($i=0;$i<100;$i++){
            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles("[ROLE_EMPRUNTEUR]");
            $user->setPassword("$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K");
            $user->setEnabled($faker->boolean());
            // date for created_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $user->setCreatedAt($date);
            // date for updated_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $user->setUpdatedAt($date);

            $manager->persist($user);
        }
    }
}
