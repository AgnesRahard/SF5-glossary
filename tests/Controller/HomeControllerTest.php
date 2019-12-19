<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    /**
     * Test la route de la page home
     *
     * @return void
     */
    public function testShowHome()
    {
        $client = static::createClient();

        $client->request('GET', '/home');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
   
}