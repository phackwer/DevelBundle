<?php

namespace SanSIS\Core\DevelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConsoleControllerTest extends WebTestCase
{
    public function testInitacl()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/consoleInitAcl');
    }

    public function testGeneratebundle()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'consoleGenerateBundle');
    }

    public function testGeneratecontroller()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/consoleGenerateController');
    }

    public function testGeneratedoctrinecrud()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/consoleGenerateDoctrineCrud');
    }

    public function testGeneratedoctrineform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/consoleGenerateDoctrineForm');
    }

}
