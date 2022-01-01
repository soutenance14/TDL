<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class SecurityTest extends LoginTest
{
    // TESTS ERROR
    public function testErrorInvalidCredentials(): void
    {
        $this->login("victor", "password");
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert-danger', 'Invalid credentials.');
        $this->randomSecuredRoute();
        // If Not Acccess Autorized, request NOK -> status code = 200, redirect 302 or 303
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());
    }

    // TESTS SUCCESS
    public function testSuccessLoginRoute(): void
    {
        $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorsLoginFormExists();
    }
    
    public function testSuccessLogin(): void
    {
        $this->login();
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->randomSecuredRoute();
        // If Acccess Autorized, request OK -> status code = 200
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSuccessLogout(): void
    {
        $this->client->request('GET', '/logout');
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode()));
        $this->client->followRedirect();
        $this->assertSelectorsLoginFormExists();
        $this->randomSecuredRoute();
        // If Acccess Autorized, request OK -> status code = 200
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());
    }

    
    
    //UTILS
    private function randomSecuredRoute(): void
    {
        // Only Auth user can access to this route
        $this->client->request('GET', '/user/new');
    }
}
