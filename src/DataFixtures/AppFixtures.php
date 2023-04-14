<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tag;
use App\Entity\Niveau;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\State;
use DateTimeImmutable;





class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
    $tagsList = ['Dev', 'System', 'Reseaux', 'Cyber', 'IOT', 'Général'];
    $stateList = ['En cours', 'Terminer', 'Abandonner'];
    $niveauList = ['B1', 'B2', 'B3', 'M1', 'M2', 'Others'];
    $roleList = ['Admin', 'Users'];
    
    $tags = array();
    foreach ($tagsList as $name) {
        $tag = new Tag();
        $tag->setName($name);
        array_push($tags, $tag);
        $manager->persist($tag);
    }

    $states = array();
    foreach ($stateList as $name) {
        $state = new State();
        $state->setName($name);
        array_push($states, $state);
        $manager->persist($state);
    }
    
    $niveaux = array();
    for ($i = 0; $i <= 5; $i++) {
        $niveaux[$i] = new Niveau();
        $niveaux[$i]->setName($niveauList[$i]);
        $manager->persist($niveaux[$i]);
    }
    
    $users = array();
    $faker = \Faker\Factory::create();
    for ($i = 0; $i < 30; $i++) {
        $users[$i] = new User();
        $users[$i]->setNiveau($niveaux[array_rand($niveaux)]);
        $users[$i]->setName($faker->firstName());
        $users[$i]->setPassword($faker->password(6,20));
        $users[$i]->addTag($tags[array_rand($tags)]);
        $users[$i]->setRole($roleList[array_rand($roleList)]);
        $manager->persist($users[$i]);
    }
        $posts = array();
        for ($i = 0; $i < 123;$i++){
            $posts[$i]= new Post();
            $posts[$i]->setState($states[array_rand($states)]);
            $posts[$i]->setTitle('test');
            $posts[$i]->setContent('Fuck la team');
            $posts[$i]->addTag($tags[array_rand($tags)]);
            $posts[$i]->setUserId($users[array_rand($users)]);
            $posts[$i]->setCratedAt(new DateTimeImmutable());
            $manager->persist($posts[$i]);
        }




    $manager->flush();
    

        // $faker = Faker\Factory::create();
        // // $product = new Product();
        // // $manager->persist($product);
        // $niveaux = array();
        // for ($i = 0; $i < 7;$i++){
        //     $niveaux[$i] = new Niveau();
        //     $niveaux[$i]->setName($faker->word);
            
        //     $manager->persist($niveaux[$i]);
        // }
        // $roles = array();
        // for ($i = 0; $i < 7;$i++){
        //     $roles[$i] = new Tag();
        //     $roles[$i]->setName($faker->word);
            
        //     $manager->persist($roles[$i]);
        // }
        // $users = array();
        // for ($i = 0; $i < 7;$i++){
        //     $users[$i] = new User();
        //     $users[$i]->setNiveau($niveaux[array_rand($niveaux)]);
        //     $users[$i]->setName($faker->firstName);
        //     $users[$i]->setPassword($faker->password(6,20));
        //     $users[$i]->addTag($roles[array_rand($roles)]);
        //     $manager->persist($users[$i]);
        // }
        // $state = new State();
        // $state->setStatus("en cours");
        // $manager->persist($state);
        // $state = new State();
        // $state->setStatus("résolu");
        // $manager->persist($state);
        // $state = new State();
        // $state->setStatus("abandonné");
        // $manager->persist($state);


        // $posts = array();
        // for ($i = 0; $i < 40;$i++){
        //     $posts[$i]= new Post();
        //     $posts[$i]->setState($state);
        //     $posts[$i]->setTitle($faker->sentence());
        //     $posts[$i]->setDescription($faker->paragraph());
        //     $posts[$i]->addTag($roles[array_rand($roles)]);
        //     $posts[$i]->setUser($users[array_rand($users)]);
        //     $posts[$i]->setCreationDate(new DateTime());
        //     $manager->persist($posts[$i]);
        //     print("tesy");}
    }
}

