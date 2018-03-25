<?php

namespace Tests\Unit\FollowedChannel;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_creates_new_record()
    {
        $channel = $this->createFollowedChannel([
            'id' => 'new id',
            'title' => 'channel title',
            'follow_to' => '2018-01-01',
        ]);

        $this->assertEquals('new id', $channel->id);
        $this->assertEquals('channel title', $channel->title);
        $this->assertInstanceOf(Carbon::class, $channel->follow_to);
        $this->assertEquals('2018-01-01', $channel->follow_to->toDateString());
    }

    function test_is_follow()
    {
        $followChannel = $this->createFollowedChannel([
            'follow_to' => now(),
        ]);

        $followChannel1 = $this->createFollowedChannel([
            'follow_to' => now()->addDay(),
        ]);

        $dontFollowChannel = $this->createFollowedChannel([
            'follow_to' => now()->subDay(),
        ]);

        $followChannel2 = $this->createFollowedChannel([
            'follow_to' => null,
        ]);

        $this->assertTrue($followChannel->isFollow());
        $this->assertTrue($followChannel1->isFollow());
        $this->assertTrue($followChannel2->isFollow());

        $this->assertFalse($dontFollowChannel->isFollow());
    }
}
