<?php

// namespace App\Tests;

// use App\Tests\Controller\LoginTest;

// class TaskNewTest extends LoginTest
// {
//     // ALL TESTS SUCCESS
//     public function testSuccessNewUserRoute(): void
//     {
//         $this->login();// real user try to auth
//         $this->client->request('GET', '/user/new');
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertSelectorTextContains('h1', 'Créer un utilisateur');
//     }

//     public function testSuccessNewUser(): void
//     {
//         $this->login();// real user try to auth
//         $crawler = $this->client->request('GET', '/user/new');
//         $buttonCrawlerNode = $crawler->selectButton('Créer');

//         // // retrieve the Form object for the form belonging to this button
//         $form = $buttonCrawlerNode->form();
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
//         $this->client->submit($form, [
//             'user[username]'    => "test".uniqid(),
//             'user[password]' => [
//                 'first' => 'password',
//                 'second' => 'password',
//             ],
//             'user[email]' => 'test@gmail.com'
//         ]);

//         //redirection get
//         $this->assertEquals(303, $this->client->getResponse()->getStatusCode());
//         $crawler = $this->client->followRedirect();
        
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertSelectorTextContains('div.alert-success', 'L\'utilisateur a bien été ajouté.');
//     }

//     //     //ALL TEST ERROR
//     // public function testErrorNewUserRoute(): void
//     // {
//     //     $this->login('victor', 'password');// wrong user try to auth
//     //     $this->client->request('GET', '/user/new');
//     //     $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode()); 
//     //     $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));          
//     // }

//     // public function testErrorNewUserRouteNoAuth(): void
//     // {
//     //     //Try to acces to user new witout access
//     //     $this->client->request('GET', '/user/new');
//     //     $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());        
//     //     $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));    
//     // }

//     // public function testErrorNewUser(): void
//     // {
//     //     $this->login();// real user try to auth
//     //     $crawler = $this->client->request('GET', '/user/new');
//     //     $buttonCrawlerNode = $crawler->selectButton('Créer');

//     //     // // retrieve the Form object for the form belonging to this button
//     //     $form = $buttonCrawlerNode->form();
//     //     // $form['user[username]'] = 'autre';
//     //     $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
//     //     $this->client->submit($form, [
//     //        //submit wrong form (no fields, username, password, email) for generate error
//     //     ]);

//     //     //redirecttion get
//     //     $this->assertFalse($this->redirectionOk($this->client->getResponse()->getStatusCode()));
//     //     //Error server intern
//     //     $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
       
//     // }

// }
