<?php

namespace Tests\Feature\Api;

use App\Http\Resources\Channel\ChannelCollection;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListBotChannelsTest extends TestCase
{
    use RefreshDatabase;

    function test_a_user_can_list_bot_channels()
    {
        $botChannel = $this->createChannel(['bot' => true, 'deleted' => false], 2);
        $this->createChannel(['bot' => true, 'deleted' => true], 1);
        $this->createChannel(['bot' => false, 'deleted' => false, 'total_reports' => 3], 1);

        $this->getJson(route('api.channels.bots'))->assertStatus(200)->assertExactJson(
            json_decode(
                (new ChannelCollection($botChannel))->toResponse(null)->getContent(),
                true
            )
        );
    }
}
