<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TermControllerTest extends WebTestCase
{

      /**
     * Test la route de la page home
     *
     * @return void
     */
    public function testShowTerm()
    {
        $client = static::createClient();

        $client->request('GET', '/term');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Glossaire');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testTerm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/term');

        $link = $crawler
            ->filter('a:contains("Ajout")') // find all links with the text "Ajout"
            ->link();

        // and click it
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', "Ajout d'un terme");
    }
}
