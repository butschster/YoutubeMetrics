<?php

namespace Tests\Unit\Channel;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificationTest extends TestCase
{
    use RefreshDatabase;

    function test_a_channel_can_be_verified_by_user()
    {
        $user = $this->createUser();

        $channel = $this->createChannel(['bot' => true, 'verified' => false]);
        $this->createChannelReport(['channel_id' => $channel->id], 5);

        $comments = $this->createComment([
            'is_spam' => true,
            'channel_id' => $channel->id
        ], 3);

        $this->assertEquals(5, $channel->reports()->count());
        $this->assertFalse($channel->fresh()->verified);
        $this->assertNull($channel->fresh()->moderated_by);

        $channel->markAsVerified($user);

        $this->assertTrue($channel->fresh()->verified);
        $this->assertEquals($user->id, $channel->fresh()->moderated_by);
        $this->assertEquals($user->id, $channel->fresh()->moderatedBy->id);
        $this->assertEquals(0, $channel->reports()->count());

        $comments->each(function ($comment) {
            $this->assertFalse($comment->fresh()->is_spam);
        });
    }
}
