<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class TaskNewTest extends LoginTest
{
    // TESTS SUCCESS
    public function testSuccessNewTaskRoute(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/task/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Créer une nouvelle tâche');
    }

    public function testSuccessNewTask(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/task/new');
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            'task[title]'    => "title".uniqid(),
            'task[content]' => 'nouveau contenu '. uniqid()
        ]);

        //redirection get
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a été bien été ajoutée.');
    }

    // TESTS ERROR
    public function testErrorNewUserRoute(): void
    {
        $this->login('victor', 'password');// wrong user try to auth
        $this->client->request('GET', '/task/new');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode()); 
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));          
    }

    public function testErrorNewUserRouteNoAuth(): void
    {
        //Try to acces to user new witout access
        $this->client->request('GET', '/task/new');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());        
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));    
    }

    public function testErrorNewTask(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/task/new');
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
           //submit wrong form (no fields, title, content) for generate error
        ]);

        // Failed proceed Form: 422 Unprocessable Entity or 500 error intern server
        $this->assertTrue($this->failedProceedForm( $this->client->getResponse()->getStatusCode()));
    }

}
