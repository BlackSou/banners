<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HitControllerTest extends WebTestCase
{
    public function testCollectEndpoint(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/collect');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/v1/collect', [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}