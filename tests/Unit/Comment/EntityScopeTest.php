<?php

namespace Tests\Unit\Comment;

use App\Entities\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityScopeTest extends TestCase
{
    use RefreshDatabase;

    function test_filter_by_channel()
    {
        $channel = $this->createChannel();
        $channel2 = $this->createChannel();

        $this->createComment(['channel_id' => $channel], 3);
        $this->createComment(['channel_id' => $channel2], 2);

        $this->assertEquals(3, Comment::filterByChannel($channel)->count());
        $this->assertEquals(2, Comment::filterByChannel($channel2)->count());
    }

    function test_filter_by_video()
    {
        $video = $this->createVideo();
        $video2 = $this->createVideo();

        $this->createComment(['video_id' => $video], 3);
        $this->createComment(['video_id' => $video2], 2);

        $this->assertEquals(3, Comment::filterByVideo($video)->count());
        $this->assertEquals(2, Comment::filterByVideo($video2)->count());
    }

    function test_gets_only_spam()
    {
        // Канал должен быть точно не ботом,
        // иначе при создании комментария у него автоматически проставляется статус спама
        $channel = $this->createChannel(['bot' => true]);
        $channel1 = $this->createChannel(['bot' => false]);

        $this->createComment(['is_spam' => true, 'channel_id' => $channel->id], 2);
        $this->createComment(['is_spam' => false, 'channel_id' => $channel1->id]);

        $this->assertEquals(2, Comment::onlySpam()->count());
    }
}
