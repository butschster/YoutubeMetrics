<?php

namespace Tests\Unit\FollowedChannel;

use App\Entities\FollowedChannel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityScopesTest extends TestCase
{
    use RefreshDatabase;

    function test_only_follows_where_follow_to_is_null()
    {
        $this->createFollowedChannel([
            'follow_to' => null,
        ]);

        $this->assertEquals(1, FollowedChannel::onlyFollow()->count());
    }

    function test_only_follows_where_follow_to_is_gt_today()
    {
        $this->createFollowedChannel([
            'follow_to' => now()->addDay(),
        ]);

        $this->assertEquals(1, FollowedChannel::onlyFollow()->count());
    }

    function test_only_follows_where_follow_to_is_today()
    {
        $this->createFollowedChannel([
            'follow_to' => now(),
        ]);

        $this->assertEquals(1, FollowedChannel::onlyFollow()->count());
    }

    function test_only_follows_where_follow_to_is_lt_today()
    {
        $this->createFollowedChannel([
            'follow_to' => now()->subDay(),
        ]);

        $this->assertEquals(0, FollowedChannel::onlyFollow()->count());
    }
}
