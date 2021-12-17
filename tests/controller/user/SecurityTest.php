<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class SecurityTest extends LoginTest
{
    //UTILS
    public function testSuccessLoginRoute(): void
    {
        $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        // Test if login field exists
        $this->assertSelectorExists('input[name="username"]');
        $this->assertSelectorExists('input[name="password"]');
        $this->assertSelectorTextContains('button', 'Se connecter');
    }
    
    public function testSuccessLogin(): void
    {
        $this->login();
        print("status ok ". $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->randomSecuredRoute();
        // If Acccess Autorized, request OK -> status code = 200
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
    
    public function testErrorInvalidCredentials(): void
    {
        $this->login("victor", "password");
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        // TODO No invalid Credentials for wrong login
        // Pourquoi la ligne ci dessous ne fonctionne pas
        // $this->assertSelectorTextContains('div.alert-danger', 'Invalid credentials.');
        $this->randomSecuredRoute();
        // If Acccess Not Autorized, request NOK -> stats code != 200, status code = 302 or 303 for redirection to login
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
    }
    private function randomSecuredRoute(): void
    {
        // Only Auth user can access to this route
        $this->client->request('GET', '/user/new');
    }
}
