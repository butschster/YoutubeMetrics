<?php

namespace Tests\Unit\Comment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityObserversTest extends TestCase
{
    use DatabaseMigrations;

    function test_updates_statistics()
    {
        $comment = $this->createComment();

        $this->assertEquals(0, $comment->likes()->count());

        $comment->update(['total_likes' => 30]);
        $comment->update(['total_likes' => 40]);
        $comment->update(['text' => 'new text']);

        $this->assertEquals(2, $comment->likes()->count());

        $this->assertEquals(30, $comment->likes()->first()->count);
        $this->assertEquals(40, $comment->likes()->offset(1)->first()->count);
    }

    function test_mark_comments_as_spam_from_bots()
    {
        $channel = $this->createChannel(['bot' => true]);
        $comment = $this->createComment(['channel_id' => $channel->id, 'is_spam' => false]);
        $this->assertTrue($comment->is_spam);

        $channel = $this->createChannel(['bot' => false]);
        $comment = $this->createComment(['channel_id' => $channel->id, 'is_spam' => false]);
        $this->assertFalse($comment->is_spam);
    }
}
