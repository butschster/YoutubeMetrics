<?php

namespace Tests\Unit\Video;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityRelationsTest extends TestCase
{
    use DatabaseMigrations;

    function test_gets_channel()
    {
        $channel = $this->createChannel();

        $video = $this->createVideo([
            'channel_id' => $channel->id
        ]);

        $this->assertEquals($channel->id, $video->channel->id);
    }

    function test_gets_tags()
    {
        $tag = $this->createTag();
        $tags = $this->createTag([], 10);
        $video = $this->createVideo();
        $video1 = $this->createVideo();

        $this->assertEquals(0, $video->tags()->count());

        $video->tags()->saveMany($tags);
        $video1->tags()->attach($tag);

        $this->assertEquals(10, $video->tags()->count());
        $this->assertEquals(1, $video1->tags()->count());
    }

    function test_gets_statistics()
    {
        $video = $this->createVideo();
        $video1 = $this->createVideo();

        $stat1 = $video->statistics()->create([
            'views' => 1000,
            'likes' => 1123,
            'dislikes' => 23,
            'comments' => 10003,
            'favorites' => 213
        ]);

        $stat2 = $video->statistics()->create([
            'views' => 101,
            'likes' => 15,
            'dislikes' => 43,
            'comments' => 4542,
            'favorites' => 78
        ]);

        $stat3 = $video1->statistics()->create([
            'views' => 781,
            'likes' => 97,
            'dislikes' => 45,
            'comments' => 45312,
            'favorites' => 4545
        ]);

        $this->assertEquals(2, $video->statistics()->count());
        $this->assertEquals(1, $video1->statistics()->count());

        $this->assertFalse($video->statistics()->get()->contains($stat3));
        $this->assertFalse($video1->statistics()->get()->contains($stat1));
        $this->assertFalse($video1->statistics()->get()->contains($stat2));
    }
    
    function test_gets_comments()
    {
        $video = $this->createVideo();
        $video1 = $this->createVideo();

        $comments = $this->createComment([], 4);
        $comments1 = $this->createComment([], 3);

        $video->comments()->saveMany($comments);
        $video1->comments()->saveMany($comments1);

        $this->assertEquals(4, $video->comments()->count());
        $this->assertEquals(3, $video1->comments()->count());
    }
}
