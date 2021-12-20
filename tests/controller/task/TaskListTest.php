<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class TaskListTest extends LoginTest
{
    //Value in db_test
    // This is util for understand tests

    // // USER
    // $admin = (
    //     new User())
    //     ->setUsername("admin")
    //     ->setRoles(["ROLE_ADMIN"])

    // $user_1 = (
    //     new User())
    //     ->setUsername("user1")

    // $user_2 = (
    //     new User())
    //     ->setUsername("user2")
    
    // //TASK
    // $adminTask = new Task();
    // $adminTask->setUser($admin);
    // ID = 1

    // $taskUser_1 = new Task();
    // $taskUser_1->setUser($user_1);
    // ID = 2
    
    // $taskUser_2 = new Task();
    // $taskUser_2->setUser($user_2);
    // ID = 3
    
    // $taskAnonymous = new Task();
    // ID = 4
    
    public function testErrorListTaskRoute(): void
    {
        $this->login("victor", "password");// wrong user try to auth
        $this->client->request('GET', '/task//');
        $this->assertRedirectToLogin();
    }

    public function testSuccessListTaskDisplay(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/task//');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Liste des tâches');

        $this->assertSelectorExists('h5.anonyme', 'Anonyme');
        $this->assertSelectorExists('h5.owner', 'Par admin');
        $this->assertSelectorExists('h5.owner', 'Par user1');
        $this->assertSelectorExists('h5.owner', 'Par user2');
    }
    

}
