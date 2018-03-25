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

    function test_gets_only_reported()
    {
        $this->createChannel(['bot' => true, 'reports' => 3], 2);
        $this->createChannel(['bot' => false, 'reports' => 3], 3);
        $this->createChannel(['bot' => false, 'reports' => 0], 4);


        $this->assertEquals(3, Channel::onlyReported()->count());
    }
}
