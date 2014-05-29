<?php

namespace SanSIS\Core\DevelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReverseControllerTest extends WebTestCase
{
    public function testEntitytarget()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/entityTarget');
    }

    public function testCreateEntities()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createEntities');
    }

}
