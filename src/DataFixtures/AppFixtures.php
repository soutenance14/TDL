<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(EntityManagerInterface $em ,UserPasswordEncoderInterface $encoder)
    {
        // Can not truncate database while the purge because the foreign keys constraint
        // --purge-with-truncate ->Impossible with the load fixtures
        // get connection for set autoincrement to 1
        $this->connection = $em->getConnection();
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
        
        $taskUser_1 = new Task();
        $taskUser_1->setTitle("User_1/ Article JS");
        $taskUser_1->setContent("Lire l'article de developpeur.com sur JS");
        $taskUser_1->setUser($user_1);

        $taskUser_2 = new Task();
        $taskUser_2->setTitle("User_2/ Regarder Projet 7");
        $taskUser_2->setContent("Le projet 7 BileMo concernant les API doit être connu avant samedi le 18/12");
        $taskUser_2->setUser($user_2);

        $taskAnonymous = new Task();
        $taskAnonymous->setTitle("Null User/ Terminer projet Wordpresse");
        $taskAnonymous->setContent("Finir le projet wordpress concernant Courchevel de Marie Dubois.");
        
        // WARNING 
        // If Database is not an SQL DB (MySQL, PosgreSQL, SQLite...), dont use 2 lines bellows for $this->connection->executeStatement
        // Set autoincrement to 1
        // Important for test, because use id to get object
        $this->connection->executeStatement("ALTER TABLE user AUTO_INCREMENT = 1;");
        $this->connection->executeStatement("ALTER TABLE task AUTO_INCREMENT = 1;");
        // WARNING 
        
        $manager->persist($admin);
        $manager->persist($user_1);
        $manager->persist($user_2);
        
        $manager->persist($adminTask);
        $manager->persist($taskUser_1);
        $manager->persist($taskUser_2);
        $manager->persist($taskAnonymous);
        
        $manager->flush();
    }
}
