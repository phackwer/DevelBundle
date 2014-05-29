<?php

namespace SanSIS\Core\DevelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QAControllerTest extends WebTestCase
{
    public function testPhpunit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/qaPhpUnit');
    }

    public function testPmd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/qaPmd');
    }

    public function testCpd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/qaCpd');
    }

    public function testCheckstyle()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/qaCheckStyle');
    }

}
