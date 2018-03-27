<?php

namespace Tests\Unit\Channel;

use App\Entities\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_creates_new_record()
    {
        $channel = $this->createChannel([
            'id' => $id = $this->faker->uuid,
            'bot' => true,
            'verified' => false,
            'deleted' => false,
            'thumb' => $thumb = $this->faker->imageUrl(300, 300),
            'name' => $name = $this->faker->sentence,
            'total_reports' => $reports = $this->faker->randomNumber(),
            'views' => $views = $this->faker->randomNumber(),
            'comments' => $comments = $this->faker->randomNumber(),
            'subscribers' => $subscribers = $this->faker->randomNumber(),
            'total_comments' => $total_comments = $this->faker->randomNumber(),
            'bot_comments' => $bot_comments = $this->faker->randomNumber(),
        ]);

        $this->assertEquals($id, $channel->id);
        $this->assertTrue($channel->bot);
        $this->assertFalse($channel->deleted);
        $this->assertFalse($channel->verified);
        $this->assertEquals($thumb, $channel->thumb);
        $this->assertEquals($name, $channel->name);
        $this->assertEquals($reports, $channel->total_reports);
        $this->assertEquals($views, $channel->views);
        $this->assertEquals($comments, $channel->comments);
        $this->assertEquals($subscribers, $channel->subscribers);
        $this->assertEquals($total_comments, $channel->total_comments);
        $this->assertEquals($bot_comments, $channel->bot_comments);
    }

    function test_gets_name()
    {
        $channel = $this->createChannel(['name' => null]);
        $this->assertEquals($channel->id, $channel->name);

        $channel = $this->createChannel(['name' => 'test']);
        $this->assertEquals('test', $channel->name);
    }

    function test_gets_link()
    {
        $channel = $this->createChannel();

        $this->assertEquals('http://localhost/channel/'.$channel->id, $channel->link);
    }

    function test_gets_youtube_link()
    {
        $channel = $this->createChannel();

        $this->assertEquals('https://www.youtube.com/channel/'.$channel->id, $channel->youtube_link);
    }

    function test_gets_top_comments_link()
    {
        $channel = $this->createChannel();

        $this->assertEquals('https://www.t30p.ru/search.aspx?s='.$channel->id, $channel->top_comments_link);
    }

    function test_gets_type()
    {
        $channel = $this->createChannel(['bot' => false, 'total_reports' => 0, 'verified' => false, 'deleted' => false]);
        $this->assertEquals(Channel::TYPE_NORMAL, $channel->type);

        $channel = $this->createChannel(['bot' => true, 'total_reports' => 10, 'verified' => false, 'deleted' => false]);
        $this->assertEquals(Channel::TYPE_BOT, $channel->type);

        $channel = $this->createChannel(['bot' => false, 'total_reports' => 10, 'verified' => false, 'deleted' => false]);
        $this->assertEquals(Channel::TYPE_REPORTED, $channel->type);

        $channel = $this->createChannel(['bot' => true, 'total_reports' => 10, 'verified' => true, 'deleted' => false]);
        $this->assertEquals(Channel::TYPE_VERIFIED, $channel->type);

        $channel = $this->createChannel(['bot' => true, 'total_reports' => 10, 'verified' => true, 'deleted' => true]);
        $this->assertEquals(Channel::TYPE_DELETED, $channel->type);
    }

    function test_marks_as_bot()
    {
        $user = $this->createUser();
        $channel = $this->createChannel(['bot' => false]);
        $comments = $this->createComment([
            'is_spam' => false,
            'channel_id' => $channel->id
        ], 3);

        $channel->markAsBot($user);

        $this->assertTrue($channel->fresh()->bot);

        $comments->each(function ($comment) {
            $this->assertTrue($comment->fresh()->is_spam);
        });
    }
}
