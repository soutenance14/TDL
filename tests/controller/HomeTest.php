<?php

namespace App\Tests;

use App\Tests\Controller\LoginTest;

class HomeTest extends LoginTest
{
    // TESTS ERROR
    public function testErrorHomeUserRoute(): void
    {
        $this->login("victor", "password");// wrong user try to auth
        $this->client->request('GET', '/');
        $this->assertRedirectToLogin();
    }

    // TESTS SUCCESS
    public function testSuccessHomeRoute(): void
    {
        $this->login();// real user try to auth
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
    }
    
    public function testSuccessHomeButtonAddUser(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $linkCrawlerNode = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->client->click($linkCrawlerNode);
        
        //new route->creer un utilisateur
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Créer un utilisateur');
        $this->assertSelectorExists('input[name="user[username]"]');
        
    }
    
    public function testSuccessHomeButtonAddTask(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $linkCrawlerNode = $crawler->selectLink('Créer une nouvelle tâche')->link();
        
        $crawler = $this->client->click($linkCrawlerNode);
        //new route->creer une tâche
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Créer une nouvelle tâche');
        $this->assertSelectorExists('input[name="task[title]"]');
    }

    public function testSuccessHomeButtonListTask(): void
    {
        $this->login();// real user try to auth
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $linkCrawlerNode = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        
        $crawler = $this->client->click($linkCrawlerNode);
        //new route->creer une tâche
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Liste des tâches');
        $this->assertSelectorExists('h5.anonyme', 'Anonyme');
        $this->assertSelectorExists('h5.owner', 'Par admin');
        $this->assertSelectorExists('h5.owner', 'Par user1');
        $this->assertSelectorExists('h5.owner', 'Par user2');
    }

}
