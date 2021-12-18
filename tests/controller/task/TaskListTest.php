<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class TaskListTest extends LoginTest
{
    // ALL TESTS SUCCESS
    public function testSuccessListTaskRoute(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/task//');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Liste des tâches');
    }
    
    public function testErrorListTaskRoute(): void
    {
        $this->login("victor", "password");// wrong user try to auth
        $this->client->request('GET', '/task//');
        $this->assertNotEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->redirectionOk($this->client->getResponse()->getStatusCode())); 
    }

}
