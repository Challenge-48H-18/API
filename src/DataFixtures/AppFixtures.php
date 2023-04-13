<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use App\Entity\Post;
use App\Entity\State;
use App\Entity\Tag;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Role\Role;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        $niveaux = array();
        for ($i = 0; $i < 7;$i++){
            $niveaux[$i] = new Niveau();
            $niveaux[$i]->setName($faker->word);
            
            $manager->persist($niveaux[$i]);
        }
        $roles = array();
        for ($i = 0; $i < 7;$i++){
            $roles[$i] = new Tag();
            $roles[$i]->setName($faker->word);
            
            $manager->persist($roles[$i]);
        }
        $users = array();
        for ($i = 0; $i < 7;$i++){
            $users[$i] = new User();
            $users[$i]->setNiveau($niveaux[array_rand($niveaux)]);
            $users[$i]->setName($faker->firstName);
            $users[$i]->setPassword($faker->password(6,20));
            $users[$i]->addTag($roles[array_rand($roles)]);
            $manager->persist($users[$i]);
        }
        $state = new State();
        $state->setStatus("en cours");
        $manager->persist($state);
        $state = new State();
        $state->setStatus("résolu");
        $manager->persist($state);
        $state = new State();
        $state->setStatus("abandonné");
        $manager->persist($state);


        $posts = array();
        for ($i = 0; $i < 40;$i++){
            $posts[$i]= new Post();
            $posts[$i]->setState($state);
            $posts[$i]->setTitle($faker->sentence());
            $posts[$i]->setDescription($faker->paragraph());
            $posts[$i]->addTag($roles[array_rand($roles)]);
            $posts[$i]->setUser($users[array_rand($users)]);
            $posts[$i]->setCreationDate(new DateTime());
            $manager->persist($posts[$i]);
            print("tesy");
        }
        $manager->flush();
    }
}
