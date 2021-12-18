<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class LoginTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    //UTILS
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
    
    public function redirectionOk($statusCode): bool{
    // https://en.wikipedia.org/wiki/HTTP_302
    // 302 redirection standard
    // 303 redirection with type request change to "GET"
    // 307 redirection with conservating type request is same
        return in_array($statusCode, [302, 303, 307]);
    }
}
