<?php

namespace Tests\Unit\Youtube\Console;

use App\Jobs\Youtube\UpdateChannelInformation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SyncFollowedChannelsTest extends TestCase
{
    use RefreshDatabase;

    function test_handle()
    {
        Bus::fake();

        $this->createFollowedChannel(['follow_to' => now()->subDay()], 4);
        $this->createFollowedChannel(['follow_to' => now()->addDay()], 2);
        $this->createFollowedChannel(['follow_to' => null], 3);

        Artisan::call('youtube:followed-channels-sync');

        Bus::assertDispatched(UpdateChannelInformation::class, 5);
    }
}
