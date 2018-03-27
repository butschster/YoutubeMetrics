<?php

namespace Tests\Unit\MetaBot\Console;

use App\Contracts\Services\MetaBot\Client;
use App\Entities\Channel;
use App\Jobs\Youtube\UpdateChannelInformation;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;

class MetaBotSyncTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_handle()
    {
        Bus::fake();

        $metabotUser = User::metabot();
        $channel = $this->createChannel([
            'bot' => false,
            'moderated_by' => null
        ]);

        $newChannelId = $this->faker->uuid;

        $this->app->instance(Client::class, $client = m::mock(Client::class));

        $client->shouldReceive('list')->andReturn(collect([
            ['id' => $channel->id],
            ['id' => $newChannelId]
        ]));

        Artisan::call('metabot:sync');

        $this->assertEquals($metabotUser->id, $channel->fresh()->moderated_by);
        $this->assertTrue($channel->fresh()->bot);

        $this->assertEquals($metabotUser->id, Channel::find($newChannelId)->moderated_by);
        $this->assertTrue(Channel::find($newChannelId)->bot);

        Bus::assertDispatched(UpdateChannelInformation::class, 2);
    }
}
