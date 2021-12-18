<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class UserListTest extends LoginTest
{
    // ALL TESTS SUCCESS
    public function testSuccessListUserRoute(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/user//');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }

    public function testErrorListUserRoute(): void
    {
        $this->login("victor", "password");// wrong user try to auth
        $this->client->request('GET', '/user//');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode())); 
    }

}
