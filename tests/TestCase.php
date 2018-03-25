<?php

namespace Tests;

use App\Entities\Bot;
use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\FollowedChannel;
use App\Entities\Tag;
use App\Entities\Video;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Unit\Youtube\FakeClient;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return FakeClient
     */
    public function createYoutubeFakeClient()
    {
        return new FakeClient();
    }

    /**
     * Create a new followed channel
     *
     * @param array $attributes
     * @param int $times
     * @return FollowedChannel
     */
    public function createFollowedChannel(array $attributes = [], int $times = null)
    {
        return factory(FollowedChannel::class, $times)->create($attributes);
    }

    /**
     * Create a new channel
     *
     * @param array $attributes
     * @param int $times
     * @return Channel
     */
    public function createChannel(array $attributes = [], int $times = null)
    {
        return factory(Channel::class, $times)->create($attributes);
    }

    /**
     * Create a new comment
     *
     * @param array $attributes
     * @param int $times
     * @return Comment
     */
    public function createComment(array $attributes = [], int $times = null)
    {
        return factory(Comment::class, $times)->create($attributes);
    }

    /**
     * Create a new video
     *
     * @param array $attributes
     * @param int $times
     * @return Video
     */
    public function createVideo(array $attributes = [], int $times = null)
    {
        return factory(Video::class, $times)->create($attributes);
    }

    /**
     * Create a new tag
     *
     * @param array $attributes
     * @param int $times
     * @return Tag
     */
    public function createTag(array $attributes = [], int $times = null)
    {
        return factory(Tag::class, $times)->create($attributes);
    }

    /**
     * Create a new bot
     *
     * @param array $attributes
     * @param int $times
     * @return Bot
     */
    public function createBot(array $attributes = [], int $times = null)
    {
        return factory(Bot::class, $times)->create($attributes);
    }
}
