<?php

namespace App\Tests\Util;

// use App\Number;
use App\Util\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    /**
     * Test si le nombre est premier
     *
     * @return void
     */
    public function testIsPair()
    {
        $number = new Number();
        $result = $number->isPair(30);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(true, $result);
    }

    /**
     * Test si le nombre est premier
     *
     * @return void
     */
    public function testIsNotPair()
    {
        $number = new Number();
        $result = $number->isPair(31);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(false, $result);
    }
}