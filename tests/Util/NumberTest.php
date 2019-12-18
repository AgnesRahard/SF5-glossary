<?php

namespace App\Tests\Util;

// use App\Number;
use App\Util\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testIsPair()
    {
        $number = new Number();
        $result = $number->isPair(31);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(true, $result);
    }
}