<?php

namespace Tests\Unit\Channel;

use App\Entities\Comment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityRelationsTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    function test_comments()
    {
        $channel = $this->createChannel();
        $comments = $this->createComment([], 3);

        $comment = $comments->shift();

        $this->assertEquals(0, $channel->comments()->count());
        
        $channel->comments()->saveMany($comments);
        
        $this->assertEquals(2, $channel->comments()->count());
        $this->assertFalse($channel->comments()->get()->contains($comment));
    }

    function test_video_comments()
    {
        $channel = $this->createChannel();

        $video = $this->createVideo(['channel_id' => $channel->id]);
        $video2 = $this->createVideo(['channel_id' => $channel->id]);

        $this->createComment(['video_id' => $video->id], 3);

        $this->assertEquals(3, $channel->videoComments()->count());

        $channel->videoComments()->create(
            factory(Comment::class)->make(['video_id' => $video2->id])->toArray()
        );

        $this->assertEquals(4, $channel->videoComments()->count());
    }

    function test_videos()
    {
        $channel = $this->createChannel();
        $video = $this->createVideo();

        $this->assertEquals(0, $channel->videos()->count());

        $channel->videos()->save($video);

        $this->assertEquals(1, $channel->videos()->count());
    }

    function test_statistics()
    {
        $channel = $this->createChannel();

        $this->assertEquals(0, $channel->statistics()->count());

        $channel->statistics()->create([
            'views' => $this->faker->randomNumber(),
            'comments' => $this->faker->randomNumber(),
            'subscribers' => $this->faker->randomNumber(),
        ]);

        $this->assertEquals(1, $channel->statistics()->count());
    }
}
