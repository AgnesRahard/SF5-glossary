<?php

namespace App\Tests\Entity;

use App\Entity\Langue;
use PHPUnit\Framework\TestCase;

class LangueTest extends TestCase
{
    /**
     * Test si le code de la langue est en ok
     *
     * @return void
     */
    public function testCodeIsCorrect()
    {
        $langue = new Langue();
        $langue->setCode('it');

        $this->assertEquals('IT', $langue->getCode());
    }

}