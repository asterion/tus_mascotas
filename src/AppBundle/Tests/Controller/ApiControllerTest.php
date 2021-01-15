<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testPet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/pet');
    }

}
