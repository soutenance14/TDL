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
    public function login($username = 'paul', $password = 'password'): void
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
        //TODO Why Sometimes is 302, sometimes is 303 redirection
        // vaild form login-> 302
        // Valid form TYpe Form (example UserType) -> 303
        //302 and 303 are status code for redirection
        return in_array($statusCode, [302, 303]);
    }
}
