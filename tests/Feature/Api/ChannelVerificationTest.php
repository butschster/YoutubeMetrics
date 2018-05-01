<?php

namespace Tests\Feature\Api;

use App\Entities\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelVerificationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_a_guests_can_check_channel()
    {
        $channel = $this->createChannel(['bot' => true, 'verified' => false, 'deleted' => false]);
        $this->assertChannelType($channel, Channel::TYPE_BOT);

        $channel = $this->createChannel(['bot' => true, 'verified' => true, 'deleted' => false]);
        $this->assertChannelType($channel, Channel::TYPE_VERIFIED);

        $channel = $this->createChannel(['bot' => true, 'verified' => true, 'deleted' => true]);
        $this->assertChannelType($channel, Channel::TYPE_DELETED);

        $this->post(route('api.channel.check'), ['channel_id' => $this->faker->uuid])->assertStatus(404);
    }

    /**
     * @param Channel $channel
     * @param string $type
     */
    protected function assertChannelType($channel, string $type): void
    {
        if ($channel instanceof Channel) {
            $channel = $channel->id;
        }

        $this->post(route('api.channel.check'), ['channel_id' => $channel])
            ->assertStatus(200)
            ->assertExactJson([
                'type' => $type
            ]);
    }
}
