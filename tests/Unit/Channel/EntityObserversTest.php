<?php

namespace Tests\Unit\Channel;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityObserversTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_clear_cache_observe()
    {
        $id = $this->faker->uuid;

        Cache::shouldReceive('forget')
            ->with(md5('channel'.$id))
            ->twice();

        $channel = $this->createChannel(['id' => $id, 'views' => 0]);

        $channel->update(['views' => 100]);
    }
}
