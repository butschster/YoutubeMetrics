<?php

namespace Tests\Unit\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityRelationsTest extends TestCase
{
    use RefreshDatabase;

    function test_gets_videos()
    {
        $tag = $this->createTag();
        $video = $this->createVideo();
        $video1 = $this->createVideo();

        $this->assertEquals(0, $tag->videos()->count());

        $tag->videos()->save($video);
        $tag->videos()->attach($video1);

        $this->assertEquals(2, $tag->videos()->count());
    }
}
