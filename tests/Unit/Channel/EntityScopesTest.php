<?php

namespace Tests\Unit\Channel;

use App\Entities\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityScopesTest extends TestCase
{
    use RefreshDatabase;

    function test_gets_only_live()
    {
        $this->createChannel(['deleted' => true], 2);
        $this->createChannel(['deleted' => false]);


        $this->assertEquals(1, Channel::live()->count());
    }

    function test_gets_only_bots()
    {
        $this->createChannel(['bot' => true], 2);
        $this->createChannel(['bot' => false]);


        $this->assertEquals(2, Channel::onlyBots()->count());
    }

    function test_gets_filter_bots()
    {
        $this->createChannel(['bot' => true], 2);
        $this->createChannel(['bot' => false]);

        $this->assertEquals(1, Channel::filterBots()->count());
    }

    function test_gets_filter_verified()
    {
        $this->createChannel(['verified' => true], 2);
        $this->createChannel(['verified' => false]);

        $this->assertEquals(1, Channel::filterVerified()->count());
    }

    function test_gets_only_reported()
    {
        $this->createChannel(['bot' => true, 'total_reports' => 3], 2);
        $this->createChannel(['bot' => false, 'total_reports' => 3], 3);
        $this->createChannel(['bot' => false, 'total_reports' => 0], 4);


        $this->assertEquals(3, Channel::onlyReported()->count());
    }
}
