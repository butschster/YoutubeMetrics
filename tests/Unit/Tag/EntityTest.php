<?php

namespace Tests\Unit\Tag;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_creates_new_record()
    {
        $tag = $this->createTag([
            'name' => 'tag1',
        ]);

        $this->assertNotEmpty($tag->id);
        $this->assertEquals('tag1', $tag->name);
    }

    function test_gets_link()
    {
        $tag = $this->createTag([
            'name' => 'tag1',
        ]);

        $this->assertEquals(route('tag.show', $tag->name), $tag->link);
    }
}
