<?php

namespace Tests\Feature\Api;

use App\Entities\Channel;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendReportToChannelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_a_user_can_be_authenticated_to_sending_report()
    {
        $channel = $this->createChannel(['reports' => 0]);

        $this->assertEquals(0, $channel->reports);

        $this->postJson(route('channel.abuse'), [
            'channel_id' => $channel->id
        ])->assertStatus(401);

        $this->assertEquals(0, $channel->fresh()->reports);
    }

    function test_an_authenticated_user_cannot_send_report_to_exists_bot_channel()
    {
        $this->signIn();

        $channel = $this->createChannel(['reports' => 0, 'bot' => true]);

        $this->assertEquals(0, $channel->reports);

        $this->postJson(route('channel.abuse'), ['channel_id' => $channel->id])
            ->assertStatus(403);

        $this->assertEquals(0, $channel->fresh()->reports);
    }

    function test_an_authenticated_user_can_send_report_to_exists_non_bot_channel()
    {
        $this->signIn();

        $channel = $this->createChannel(['reports' => 0, 'bot' => false]);
        $this->shouldChannelCacheClear($channel->id);

        $this->assertEquals(0, $channel->reports);

        $this->postJson(route('channel.abuse'), [
            'channel_id' => $channel->id
        ])->assertStatus(200)->assertJson([
            'type' => Channel::TYPE_REPORTED
        ]);

        $this->assertEquals(1, $channel->fresh()->reports);
    }

    function test_an_authenticated_user_can_send_report_to_non_exists_channel()
    {
        $this->signIn();

        $channelId = $this->faker->uuid;
        $this->shouldChannelCacheClear($channelId);

        $this->assertNull(Channel::find($channelId));

        $this->postJson(route('channel.abuse'), [
            'channel_id' => $channelId
        ])->assertStatus(200)->assertJson([
            'type' => Channel::TYPE_REPORTED
        ]);

        $this->assertEquals(1, Channel::find($channelId)->reports);
    }
}
