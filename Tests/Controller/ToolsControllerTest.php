<?php

namespace SanSIS\Core\DevelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ToolsControllerTest extends WebTestCase
{
    public function testCacheclear()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/toolsCacheClear');
    }

    public function testServicelist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/toolsServiceList');
    }

    public function testRouterdebug()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/toolsRouterDebug');
    }

}
