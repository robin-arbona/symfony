<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;


class AppFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        $user = new User();
        $users = [];

        $user->setEmail('robin@laplateforme.io');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $manager->persist($user);
        $users[] = $user;

        $user2 = new User();
        $user2->setEmail('boyer.abbey@gutkowski.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passwordHasher->hashPassword($user2, 'user'));
        $manager->persist($user2);
        $users[] = $user2;

        $user3 = new User();
        $user3->setEmail($faker->email);
        $user3->setRoles(['ROLE_USER']);
        $user3->setPassword($this->passwordHasher->hashPassword($user3, 'user'));
        $manager->persist($user3);
        $users[] = $user3;

        $manager->flush();


        for ($i = 1; $i <= 50; $i++) {

            $post = new Post();
            $post->setTitle($faker->text("30"));
            $post->setContent($faker->text(1000));
            $post->setAuthor($users[$faker->numberBetween(0, 2)]);
            $post->setType($faker->randomElement(['science', 'outdoor', 'sport', 'dum']));
            $post->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'));
            $post->setCoverPic("https://picsum.photos/id/${i}/300/200");
            $manager->persist($post);
        }





        $manager->flush();
    }
}
