<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LunchControllerTest extends WebTestCase
{
    public function testGetLunch()
    {
        $client = static::createClient();
        $client->request('GET', '/lunch');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent());
        $this->assertEquals(2, count($data));
        $this->assertEquals('Salad', $data[0]->title);
        $this->assertEquals('Hotdog', $data[1]->title);
    }
}
