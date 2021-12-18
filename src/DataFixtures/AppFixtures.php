<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    // public function load(ObjectManager $manager, UserPasswordEncoderInterface $encoder): void
    public function load(ObjectManager $manager): void
    {
        // USER
        $admin = (
            new User())
            ->setUsername("admin")
            ->setRoles(["ROLE_ADMIN"])
            ->setEmail("admin@gmail.com")
            ;
        $admin->setPassword($this->encoder->encodePassword($admin, "password"));
        
        $user_1 = (
            new User())
            ->setUsername("user1")
            ->setEmail("user1@gmail.com")
            ;
        $user_1->setPassword($this->encoder->encodePassword($user_1, "password"));
        
        $user_2 = (
            new User())
            ->setUsername("user2")
            ->setEmail("user2@gmail.com")
            ;
        $user_2->setPassword($this->encoder->encodePassword($user_2, "password"));
        
        // Task

        $adminTask = new Task();
        $adminTask->setTitle("Admin/ Apprendre PHP");
        $adminTask->setContent("Voir le tutoriel sur PHP8 du site apprendre.com");
        $adminTask->setUser($admin);
        
        $user_1Task = new Task();
        $user_1Task->setTitle("User_1/ Article JS");
        $user_1Task->setContent("Lire l'article de developpeur.com sur JS");
        $user_1Task->setUser($user_1);

        $user_2Task = new Task();
        $user_2Task->setTitle("User_2/ Regarder Projet 7");
        $user_2Task->setContent("Le projet 7 BileMo concernant les API doit être connu avant samedi le 18/12");
        $user_2Task->setUser($user_2);

        $anonymousTask = new Task();
        $anonymousTask->setTitle("Null User/ Terminer projet Wordpresse");
        $anonymousTask->setContent("Finir le projet wordpress concernant Courchevel de Marie Dubois.");
        
        $manager->persist($admin);
        $manager->persist($user_1);
        $manager->persist($user_2);
        
        $manager->persist($adminTask);
        $manager->persist($user_1Task);
        $manager->persist($user_2Task);
        $manager->persist($anonymousTask);
        
        $manager->flush();
    }
}
