<?php

namespace Tests\Feature\Api;

use App\Events\Channel\Moderated;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelModerationTest extends TestCase
{
    use RefreshDatabase;

    function test_only_moderator_user_can_mark_channel_as_bot()
    {
        Event::fake();

        $this->signInAsModerator();
        $channel = $this->createChannel(['bot' => false]);

        $this->sendRequest($channel, 'bot');

        Event::assertDispatched(Moderated::class, function ($e) use ($channel) {
            return $e->channel->id === $channel->id;
        });

        $this->assertTrue($channel->fresh()->bot);
    }

    function test_only_moderator_user_can_mark_channel_as_normal()
    {
        Event::fake();

        $this->signInAsModerator();
        $channel = $this->createChannel(['bot' => true, 'total_reports' => 3]);
        $this->createChannelReports($channel, 3);

        $this->sendRequest($channel, 'normal');

        Event::assertDispatched(Moderated::class, function ($e) use ($channel) {
            return $e->channel->id === $channel->id;
        });

        $this->assertFalse($channel->fresh()->bot);

        $this->assertEquals(3, $channel->fresh()->total_reports);
        $this->assertEquals(3, $channel->reports()->count());
    }

    function test_only_moderator_user_can_mark_channel_as_verified()
    {
        Event::fake();

        $this->signInAsModerator();
        $channel = $this->createChannel(['bot' => true, 'total_reports' => 3, 'verified' => false]);
        $this->createChannelReports($channel, 3);

        $this->sendRequest($channel, 'verified');

        Event::assertDispatched(Moderated::class, function ($e) use ($channel) {
            return $e->channel->id === $channel->id;
        });

        $channel = $channel->fresh();

        $this->assertTrue($channel->verified);
        $this->assertFalse($channel->bot);
        $this->assertEquals(0, $channel->total_reports);
        $this->assertEquals(0, $channel->reports()->count());
    }

    function test_non_moderator_user_cannot_moderate_channel()
    {
        Event::fake();

        $this->signIn();
        $channel = $this->createChannel();
        $this->post(route('api.channel.moderate', $channel))->assertStatus(403);

        Event::assertNotDispatched(Moderated::class);
    }

    function test_guests_cannot_moderate_channel()
    {
        Event::fake();

        $channel = $this->createChannel();
        $this->post(route('api.channel.moderate', $channel))->assertStatus(403);

        Event::assertNotDispatched(Moderated::class);
    }

    /**
     * @param $channel
     * @param $status
     */
    protected function sendRequest($channel, $status): void
    {
        $this->post(route('api.channel.moderate', $channel), ['status' => $status])
            ->assertStatus(200)
            ->assertExactJson(['status' => true]);
    }
}


