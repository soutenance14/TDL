<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class LoginTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    // UTILS ASSERT
    public function assertSelectorsLoginFormExists(): void
    {
        // Test if login field exists
        $this->assertSelectorExists('input[name="username"]');
        $this->assertSelectorExists('input[name="password"]');
        $this->assertSelectorTextContains('button', 'Se connecter');
    }

    public function assertRedirectToLogin(): void
    {
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode())); 
        $this->client->followRedirect();
        $this->assertSelectorsLoginFormExists();
    }

    // UTILS
    public function login($username = 'admin', $password = 'password'): void
    {
        $crawler = $this->client->request('GET', '/login');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('Se connecter');

        // // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        $this->client->submit($form, [
            'username'    => $username,
            'password' => $password,
        ]);
    }
    
    public function redirectionOk($statusCode): bool
    {
    // https://en.wikipedia.org/wiki/HTTP_302
    // 302 redirection standard
    // 303 redirection with type request change to "GET"
    // 307 redirection with conservating type request is same
        return in_array($statusCode, [302, 303, 307]);
    }

    public function failedProceedForm($statusCode): bool
    {
        //422 Unprocessable Entity
        //500 Error Intern Serveur
        return in_array($statusCode, [422, 500]);
    }
   
}
