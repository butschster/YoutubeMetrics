<?php

namespace Tests\Unit\Comment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_creates_new_record()
    {
        $video = $this->createVideo();
        $channel = $this->createChannel(['bot' => false]);

        $comment = $this->createComment([
            'id' => $id = $this->faker->uuid,
            'video_id' => $video->id,
            'channel_id' => $channel->id,
            'text' => $text = $this->faker->sentence,
            'total_likes' => $total_likes = $this->faker->randomNumber(),
            'is_spam' => false,
        ]);

        $this->assertEquals($id, $comment->id);
        $this->assertEquals($video->id, $comment->video_id);
        $this->assertEquals($channel->id, $comment->channel_id);
        $this->assertEquals($text, $comment->text);
        $this->assertEquals($total_likes, $comment->total_likes);
        $this->assertFalse($comment->is_spam);
    }

    function test_gets_formatted_date()
    {
        $comment = $this->createComment();

        $this->assertEquals(format_date($comment->created_at), $comment->formatted_date);
    }

    function test_gets_youtube_link()
    {
        $comment = $this->createComment();

        $this->assertEquals("https://www.youtube.com/watch?v={$comment->video_id}&lc={$comment->id}", $comment->youtube_link);
    }
}
