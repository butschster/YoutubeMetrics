<?php

namespace Tests\Feature\Api\Video;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListVideoTest extends TestCase
{
    use RefreshDatabase;

    function test_index()
    {
        $video = $this->createVideo();

        $this->getJson(route('api.videos'))
            ->assertStatus(200)
            ->assertJsonStructure($this->responseStructure());
    }

    function test_index_with_spam_comments()
    {
        $video = $this->createVideo();

        $this->json('GET', route('api.videos'), ['include' => ['spam_comments']])
            ->assertStatus(200)
            ->assertJsonStructure($this->responseStructure(['spam_comments']));
    }

    /**
     * @param array $include
     * @return array
     */
    protected function responseStructure(array $include = []): array
    {
        $stat = ['views', 'likes', 'dislikes', 'comments',];

        return [
            'data' => [
                [
                    'id',
                    'title',
                    'description',
                    'stat' => array_merge($stat, $include),
                    'created_at',
                    'updated_at',
                    'channel' => ['id', 'name', 'links' => ['self', 'thumb']],
                    'links' => ['self', 'thumb']
                ]
            ],
            'links' => [
                'first', 'last', 'prev', 'next'
            ],
            'meta' => [
                'current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total'
            ]
        ];
    }
}
