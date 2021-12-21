<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class TaskEditAndDeleteTest extends LoginTest
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

    // LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--
    // LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--LIST--
    
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

    // EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--
    // EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--EDIT--
    
    // TESTS ERROR
    public function testErrorEditTaskFromAnotherUserRoute(): void
    {
        $this->login(); // real user try to auth
        //user owner for id task 2 is not the auth user in login method  
        $this->client->request('GET', '/task/2/edit');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-danger', 'Vous n\'avez pas les droits suffisants pour supprimer cette tâche.');
    }

    public function testErrorEditAnonymousTask(): void
    {
        $this->login("user1", "password"); // user1 is not admin
        //task 4 is anonymous
        $this->client->request('GET', '/task/4/edit');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-danger', 'Vous n\'avez pas les droits suffisants pour supprimer cette tâche.');
    }

    // TESTS SUCCESS
    public function testSuccessEditOneOfMyTask(): void
    {
        $this->login();// admin user try to auth
        $crawler = $this->client->request('GET', '/task/1/edit');
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        
        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            'task[title]'    => "title".uniqid(),
            'task[content]' => 'Un nouveau content'. uniqid()
        ]);
        
        // redirection get
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a bien été modifiée.');
    }
    
    public function testSuccessEditAnonymousTask(): void
    {
        $this->login();// admin user try to auth
        $crawler = $this->client->request('GET', '/task/4/edit');
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        
        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            'task[title]'    => "title".uniqid(),
            'task[content]' => 'Un nouveau content'. uniqid()
        ]);
        
        // redirection get
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a bien été modifiée.');
    }


    // DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--
    // DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--DELETE--

    // TESTS ERROR
    public function testErrorDeleteTaskFromAnotherUserRoute(): void
    {
        $this->login(); // admin auth
        //task 2 is created by user1, not admin  
        $this->client->request('POST', '/task/2');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-danger', 'Vous n\'avez pas les droits suffisants pour supprimer cette tâche.');
    }

    public function testErrorDeleteAnonymousTaskNotAdmin(): void
    {
        $this->login("user1", "password"); // user1 is not admin
        
        //task 4 is anonymous
        $this->client->request('POST', '/task/4');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-danger', 'Vous n\'avez pas les droits suffisants pour supprimer cette tâche.');
    }

    // // // TESTS SUCCESS
   
    public function testSuccessDeleteOneOfMyTask(): void
    {
        $this->login("user1", "password"); // user 2 auth
        
        //task id 2 is created by user1
        $this->client->request('POST', '/task/2');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a bien été supprimée.');
    }
   
    public function testSuccessDeleteAnonymousTask(): void
    {
        $this->login(); // admin auth
 
        // task id = 4 is anonymous
        $this->client->request('POST', '/task/4');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a bien été supprimée.');
    }
}
