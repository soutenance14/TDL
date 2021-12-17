<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserEdit extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    //UTILS
    private function login($username = 'paul', $password = 'password'): void
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        // Test if login field exists
        $this->assertSelectorExists('input[name="username"]');
        $this->assertSelectorExists('input[name="password"]');
        $this->assertSelectorTextContains('button', 'Se connecter');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Se connecter');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        $this->client->submit($form, [
            'username'    => $username,
            'password' => $password,
        ]);

        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
    }
    
    private function redirectionOk($statusCode): bool{
        //TODO Savoir pourquoi 302 ou 303 parfois
        //302 and 303 are status code for redirection
        return in_array($statusCode, [302, 303]);
    }
    
    // ALL TESTS SUCCESS
    public function testSuccessEditUserRoute(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/user/2/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // // $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Modifier');
    }

    public function testSuccessEditUser(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/user/2/edit');
        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        // $form['user[username]'] = 'autre';
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
        //TODO Savoir pourquoi 303
        $this->assertEquals(303, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', 'L\'utilisateur a bien été modifié.');
    }

        //ALL TEST ERROR
    public function testErrorEditUserRoute(): void
    {
        $this->login('victor', 'password');// wrong user try to auth
        $this->client->request('GET', '/user/2/edit');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());  
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));          
    }

    public function testErrorEditUserRouteNoAuth(): void
    {
        //Try to acces to user new witout access
        $this->client->request('GET', '/user/2/edit');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());        
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));    
    }

    public function testErrorEditUser(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/user/2/edit');
        $buttonCrawlerNode = $crawler->selectButton('Modifier');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        // $form['user[username]'] = 'autre';
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            //submit wrong form (no fields, username, password, email) for generate error
            //info username and email is "autogetting" can not write here
            //not password, this is necessaru ->
            // 'user[password]' => [
            //     'first' => 'password',
            //     'second' => 'password',
            // ],
        ]);
        //redirecttion get
        $this->assertFalse($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        //Error server intern
        $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
       
    }

}
