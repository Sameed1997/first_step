<?php

namespace Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class WillExpireAtTest extends TestCase
{
    
    public function testReturnsDueTimeWhenDifferenceIs90MinutesOrLess()
    {
        $due_time = Carbon::now()->addMinutes(80)->format('Y-m-d H:i:s');
        $created_at = Carbon::now()->format('Y-m-d H:i:s');

        $result = YourClass::willExpireAt($due_time, $created_at);

        $this->assertEquals($due_time, $result);
    }

   
    public function testReturnsCreatedAtPlus90MinutesWhenDifferenceIsLessThan24Hours()
    {
        $due_time = Carbon::now()->addHours(10)->format('Y-m-d H:i:s');
        $created_at = Carbon::now()->format('Y-m-d H:i:s');

        $expected = Carbon::parse($created_at)->addMinutes(90)->format('Y-m-d H:i:s');

        $result = YourClass::willExpireAt($due_time, $created_at);

        $this->assertEquals($expected, $result);
    }

    public function testReturnsCreatedAtPlus16HoursWhenDifferenceIsBetween24And72Hours()
    {
        $due_time = Carbon::now()->addHours(30)->format('Y-m-d H:i:s');
        $created_at = Carbon::now()->format('Y-m-d H:i:s');

        $expected = Carbon::parse($created_at)->addHours(16)->format('Y-m-d H:i:s');

        $result = YourClass::willExpireAt($due_time, $created_at);
        $this->assertEquals($expected, $result);
    }

    public function testReturnsDueTimeMinus48HoursWhenDifferenceIsMoreThan72Hours()
    {
        $due_time = Carbon::now()->addHours(100)->format('Y-m-d H:i:s');
        $created_at = Carbon::now()->format('Y-m-d H:i:s');

        $expected = Carbon::parse($due_time)->subHours(48)->format('Y-m-d H:i:s');

        $result = YourClass::willExpireAt($due_time, $created_at);
        $this->assertEquals($expected, $result);
    }
}
