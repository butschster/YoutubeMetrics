<?php

namespace Tests;

use App\Entities\Bot;
use App\Entities\Comment;
use App\Entities\Tag;
use App\Entities\Video;
use App\Entities\YoutubeKey;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Unit\Youtube\FakeClient;
use Tests\Utility\{
    ChannelHelpers, UserHelpers
};

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, UserHelpers, ChannelHelpers;
    /**
     * @return FakeClient
     */
    public function createYoutubeFakeClient()
    {
        return new FakeClient();
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
     * Create a new youtube key
     *
     * @param array $attributes
     * @param int $times
     * @return Tag
     */
    public function createYoutubeKey(array $attributes = [], int $times = null)
    {
        return factory(YoutubeKey::class, $times)->create($attributes);
    }
}
