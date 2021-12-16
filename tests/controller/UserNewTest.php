<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserNewTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

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

        //TODO Savoir pourquoi 302
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
    
    public function testSuccessNewUserRoute(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/user/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // // $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');
    }

    public function testErrorNewUserRoute(): void
    {
        $this->login('victor', 'password');// wrong user try to auth
        $this->client->request('GET', '/user/new');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());        
    }

    public function testSuccessNewUser(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/user/new');
        $buttonCrawlerNode = $crawler->selectButton('Créer');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        // $form['user[username]'] = 'autre';
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            'user[username]'    => "test240",
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
        $this->assertSelectorTextContains('div.alert-success', 'L\'utilisateur a bien été ajouté.');
    }

    public function testErrorNewUser(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/user/new');
        $buttonCrawlerNode = $crawler->selectButton('Créer');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        // $form['user[username]'] = 'autre';
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        $this->client->submit($form, [
            //forget username for generate error
            'user[password]' => [
                'first' => 'password',
                'second' => 'password',
            ],
            'user[email]' => 'test@gmail.com'
        ]);

        //redirecttion get
        $this->assertNotEquals(303, $this->client->getResponse()->getStatusCode());
        //Error server intern
        $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
       
    }



}
