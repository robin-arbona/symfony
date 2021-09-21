<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {

            $post = new Post();
            $post->setTitle($faker->text("30"));
            $post->setContent($faker->text(1000));
            $post->setAuthor(1);
            $post->setType($faker->randomElement(['science', 'outdoor', 'sport', 'dum']));
            $post->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'));
            $post->setCoverPic("https://picsum.photos/id/${i}/300/200");
            $manager->persist($post);
        }


        $manager->flush();
    }
}
