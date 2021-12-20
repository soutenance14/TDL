<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class UserNewTest extends LoginTest
{

    //ALL TEST ERROR

    public function testErrorNewUserNoAuth(): void
    {
        //Try to acces to user new witout access
        $this->client->request('GET', '/user/new'); 
        $this->assertRedirectToLogin();
    }

    public function testErrorNewUserWrongForm(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/user/new');
        $buttonCrawlerNode = $crawler->selectButton('Créer');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            //submit wrong form (no fields, username, password, email) for generate error
        ]);

        // Failed proceed Form: 422 Unprocessable Entity or 500 error intern server
        $this->assertTrue($this->failedProceedForm( $this->client->getResponse()->getStatusCode()));
    }

    // ALL TESTS SUCCESS

    public function testSuccessNewUser(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/user/new');
        $buttonCrawlerNode = $crawler->selectButton('Créer');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            'user[username]'    => "test".uniqid(),
            'user[password]' => [
                'first' => 'password',
                'second' => 'password',
            ],
            'user[email]' => 'test@gmail.com'
        ]);

        //redirection get
        $this->assertEquals(303, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'L\'utilisateur a bien été ajouté.');
    }

}
