<?php

namespace Tests\Unit\Video;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_creates_new_record()
    {
        $channel = $this->createChannel();
        $video = $this->createVideo([
            'id' => $id = $this->faker->uuid,
            'title' => $title = $this->faker->sentence,
            'description' => $description = $this->faker->paragraph,
            'channel_id' => $channel->id,
            'thumb' => $thumb = $this->faker->imageUrl(300, 300),
            'views' => 1000,
            'likes' => 1123,
            'dislikes' => 23,
            'comments' => 10003,
            'favorites' => 213
        ]);

        $this->assertEquals($id, $video->id);
        $this->assertEquals($title, $video->title);
        $this->assertEquals($channel->id, $video->channel_id);
        $this->assertEquals($description, $video->description);
        $this->assertEquals($thumb, $video->thumb);
        $this->assertEquals(1000, $video->views);
        $this->assertEquals(1123, $video->likes);
        $this->assertEquals(23, $video->dislikes);
        $this->assertEquals(10003, $video->comments);
        $this->assertEquals(213, $video->favorites);
    }

    function test_gets_diff_date()
    {
        $date = now();
        $video = $this->createVideo([
            'created_at' => $date
        ]);

        $this->assertEquals($date->diffForHumans(), $video->diff_date);
    }
}
