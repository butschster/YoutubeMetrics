<?php

namespace Tests\Unit\Comment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityRelationsTest extends TestCase
{
    use DatabaseMigrations;

    function test_video()
    {
        $video = $this->createVideo();
        $video2 = $this->createVideo();

        $comment = $this->createComment([
            'video_id' => $video->id
        ]);

        $this->assertEquals($video->id, $comment->video->id);
        $this->assertNotFalse($video2->id, $comment->video->id);
    }

    function test_channel()
    {
        $channel = $this->createChannel();
        $channel2 = $this->createChannel();

        $comment = $this->createComment([
            'channel_id' => $channel->id
        ]);

        $this->assertEquals($channel->id, $comment->channel->id);
        $this->assertNotFalse($channel2->id, $comment->channel->id);
    }

    function test_likes()
    {
        $comment = $this->createComment();

        $this->assertEquals(0, $comment->likes()->count());

        $comment->likes()->create(['count' => 10]);
        $comment->likes()->create(['count' => 20]);

        $this->assertEquals(2, $comment->likes()->count());

        $this->assertEquals(10, $comment->likes()->first()->count);
        $this->assertEquals(20, $comment->likes()->offset(1)->first()->count);
    }
}
