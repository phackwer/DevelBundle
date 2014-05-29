<?php

namespace Ibram\Core\DevelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GenerateControllerTest extends WebTestCase
{
    public function testAppcorebundle()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generateAppCoreBundle');
    }

    public function testConfigyml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generateConfigYml');
    }

    public function testParametersyml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generateParametersYml');
    }

}
