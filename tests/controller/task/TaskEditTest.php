<?php

// namespace App\Tests;

// use App\Tests\Controller\LoginTest;

// class TaskEdit extends LoginTest
// {
//         // ALL TESTS SUCCESS
//     public function testSuccessEditUserRoute(): void
//     {
//         $this->login();// real user try to auth
//         $this->client->request('GET', '/task/2/edit');
//         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//         $this->assertSelectorTextContains('h1', 'Modifier');
//     }

//     // public function testSuccessEditUser(): void
//     // {
//     //     $this->login();// real user try to auth
//     //     $crawler = $this->client->request('GET', '/user/2/edit');
//     //     $buttonCrawlerNode = $crawler->selectButton('Modifier');

//     //     // // retrieve the Form object for the form belonging to this button
//     //     $form = $buttonCrawlerNode->form();
//     //     $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
//     //     $this->client->submit($form, [
//     //         'user[username]'    => "test".uniqid(),
//     //         'user[password]' => [
//     //             'first' => 'password',
//     //             'second' => 'password',
//     //         ],
//     //         'user[email]' => 'test@gmail.com'
//     //     ]);

//     //     // redirection get
//     //     $this->assertEquals(303, $this->client->getResponse()->getStatusCode());
//     //     $crawler = $this->client->followRedirect();
        
//     //     $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
//     //     $this->assertSelectorTextContains('div.alert-success', 'L\'utilisateur a bien été modifié.');
//     // }

//     //     //ALL TEST ERROR
//     // public function testErrorEditUserRoute(): void
//     // {
//     //     $this->login('victor', 'password');// wrong user try to auth
//     //     $this->client->request('GET', '/user/2/edit');
//     //     $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());  
//     //     $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));          
//     // }

//     // public function testErrorEditUser(): void
//     // {
//     //     $this->login();// real user try to auth
//     //     $crawler = $this->client->request('GET', '/user/2/edit');
//     //     $buttonCrawlerNode = $crawler->selectButton('Modifier');

//     //     // // retrieve the Form object for the form belonging to this button
//     //     $form = $buttonCrawlerNode->form();
//     //     // $form['user[username]'] = 'autre';
//     //     $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
//     //     $this->client->submit($form, [
//     //         //submit wrong form (no fields, username, password, email) for generate error
//     //         //info username and email is "autogetting" can not write here
//     //         //not password, this is necessaru ->
//     //         // 'user[password]' => [
//     //         //     'first' => 'password',
//     //         //     'second' => 'password',
//     //         // ],
//     //     ]);
//     //     //redirecttion get
//     //     $this->assertFalse($this->redirectionOk($this->client->getResponse()->getStatusCode()));
//     //     //Error server intern
//     //     $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
//     // }

// }
