<?php

namespace Tests\Feature\Api;

use App\Entities\Channel;
use App\Events\Channel\Reported;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendReportToChannelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_a_user_can_be_authenticated_to_sending_report()
    {
        Event::fake();

        $channel = $this->createChannel(['total_reports' => 0]);

        $this->assertEquals(0, $channel->total_reports);

        $this->sendReport($channel)->assertStatus(401);

        Event::assertNotDispatched(Reported::class);

        $this->assertEquals(0, $channel->fresh()->total_reports);
    }

    function test_an_authenticated_user_cannot_send_report_to_exists_bot_channel()
    {
        Event::fake();

        $this->signIn();

        $channel = $this->createChannel(['total_reports' => 0, 'bot' => true]);

        $this->assertEquals(0, $channel->total_reports);

        $this->sendReport($channel)->assertStatus(403);

        Event::assertNotDispatched(Reported::class);
        $this->assertEquals(0, $channel->fresh()->total_reports);
    }

    function test_an_authenticated_user_can_send_report_to_exists_non_bot_channel()
    {
        Event::fake();

        $this->signIn();

        $channel = $this->createChannel(['total_reports' => 0, 'bot' => false, 'verified' => false, 'deleted' => false]);
        //$this->shouldChannelCacheClear($channel->id);

        $this->assertEquals(0, $channel->total_reports);

        $this->sendReport($channel)->assertStatus(200)->assertJson([
            'type' => Channel::TYPE_REPORTED
        ]);

        Event::assertDispatched(Reported::class, function ($e) use ($channel) {
            return $e->channel->id === $channel->id;
        });

        $this->assertEquals(1, $channel->fresh()->total_reports);
    }

    function test_an_authenticated_user_can_send_report_to_non_exists_channel()
    {
        Event::fake();

        $this->signIn();

        $channelId = $this->faker->uuid;
        //$this->shouldChannelCacheClear($channelId);

        $this->assertNull(Channel::find($channelId));

        $this->postJson(route('api.channel.report'), [
            'channel_id' => $channelId
        ])->assertStatus(200)->assertJson([
            'type' => Channel::TYPE_REPORTED
        ]);

        Event::assertDispatched(Reported::class, function ($e) use ($channelId) {
            return $e->channel->id === $channelId;
        });

        $this->assertEquals(1, Channel::find($channelId)->total_reports);
    }

    function test_a_user_can_sent_only_one_report_to_channel()
    {
        $this->signIn();

        $channelId = $this->faker->uuid;

        $this->postJson(route('api.channel.report'), ['channel_id' => $channelId])->assertStatus(200);
        $this->postJson(route('api.channel.report'), ['channel_id' => $channelId])->assertStatus(403);
    }

    /**
     * @param $channel
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function sendReport($channel): \Illuminate\Foundation\Testing\TestResponse
    {
        return $this->postJson(route('api.channel.report'), [
            'channel_id' => $channel->id
        ]);
    }
}
