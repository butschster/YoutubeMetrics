<?php

namespace Tests\Unit\Youtube\Jobs;

use App\Entities\Channel;
use App\Jobs\Youtube\UpdateChannelInformation;
use App\Jobs\Youtube\UpdateComments;
use App\Services\Youtube\ResponseCollection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\Youtube\FakeClient;

class UpdateCommentsTest extends TestCase
{
    use DatabaseMigrations;

    function test_handle()
    {
        Bus::fake();

        $channel = $this->createChannel([
           'id' => 'UCbFiIWB5XRjteh_oHnUr6mw'
        ]);

        $video = $this->createVideo([
            'id' => 'm4Jtj2lCMAA'
        ]);

        $this->assertEquals(0, $video->comments()->count());
        $this->assertEquals(2, Channel::count());

        $client = new FakeClient();
        $client->shouldReturn(function (array $params) {
            return $this->youtubeResponse($params);
        });

        $comments = $client->getCommentThreads($video->id);
        $job = new UpdateComments($video->id, $comments);

        $job->handle();
        Bus::assertDispatched(UpdateChannelInformation::class, function ($job) {
            return in_array('UCaWgtSpS-YGwD-0WEgQX0mg', $job->channelIds);
        });

        $this->assertEquals(2, $video->comments()->count());

        $this->assertTrue($video->comments()->where('channel_id', $channel->id)->exists());
        $this->assertTrue($video->comments()->where('channel_id', 'UCaWgtSpS-YGwD-0WEgQX0mg')->exists());

        $firstComment = $video->comments()->where('channel_id', $channel->id)->first();
        $secondComment = $video->comments()->where('channel_id', 'UCaWgtSpS-YGwD-0WEgQX0mg')->first();

        $this->assertEquals(51615, $firstComment->text);
        $this->assertEquals('2018-02-20 14:22:26', $firstComment->created_at->toDateTimeString());
        $this->assertEquals(0, $firstComment->total_likes);

        $this->assertEquals('test', $secondComment->text);
        $this->assertEquals('2018-01-11 06:11:55', $secondComment->created_at->toDateTimeString());
        $this->assertEquals(0, $secondComment->total_likes);
    }

    function test_handle_with_not_exists_video_in_database()
    {
        $client = new FakeClient();
        $client->shouldReturn(function (array $params) {
            return $this->youtubeResponse($params);
        });

        $job = new UpdateComments('test', new ResponseCollection());

        $client = new FakeClient();

        Log::shouldReceive('debug')->once()->with("Video with id [test] not found.");
        $job->handle($client);
    }

    private function youtubeResponse(array $params)
    {
        return <<<EOL
{
  "kind": "youtube#commentThreadListResponse",
  "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/J4VtO1aVIYWXz9aDwxpTez5X60E\"",
  "nextPageToken": "next_page",
  "pageInfo": {
    "totalResults": 19,
    "resultsPerPage": 20
  },
  "items": [
    {
      "kind": "youtube#commentThread",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/8eipJOm1SorHcjQA09jC-y80hpk\"",
      "id": "UgyljQDjYhIyWV0H2Ct4AaABAg",
      "snippet": {
        "videoId": "m4Jtj2lCMAA",
        "topLevelComment": {
          "kind": "youtube#comment",
          "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/o_7icWJGgTgKNmsgELr31nWUx38\"",
          "id": "UgyljQDjYhIyWV0H2Ct4AaABAg",
          "snippet": {
            "authorDisplayName": "Ник Абузер",
            "authorProfileImageUrl": "https://yt3.ggpht.com/-XuIYuWz1apg/AAAAAAAAAAI/AAAAAAAAAAA/Wy0onPtENSg/s28-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "authorChannelUrl": "http://www.youtube.com/channel/UCbFiIWB5XRjteh_oHnUr6mw",
            "authorChannelId": {
              "value": "UCbFiIWB5XRjteh_oHnUr6mw"
            },
            "videoId": "m4Jtj2lCMAA",
            "textDisplay": "51615",
            "textOriginal": "51615",
            "canRate": true,
            "viewerRating": "none",
            "likeCount": 0,
            "publishedAt": "2018-02-20T14:22:26.000Z",
            "updatedAt": "2018-02-20T14:22:26.000Z"
          }
        },
        "canReply": true,
        "totalReplyCount": 0,
        "isPublic": true
      }
    },
    {
      "kind": "youtube#commentThread",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/Y9W1vBLGOQSGFk6IzKrXKV-u6xA\"",
      "id": "Ugw8dvj_8a-hjnHXx7l4AaABAg",
      "snippet": {
        "videoId": "m4Jtj2lCMAA",
        "topLevelComment": {
          "kind": "youtube#comment",
          "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/JgF9DvuIPFgFpcWWTpe1DHCS-Iw\"",
          "id": "Ugw8dvj_8a-hjnHXx7l4AaABAg",
          "snippet": {
            "authorDisplayName": "Rj Nombres",
            "authorProfileImageUrl": "https://yt3.ggpht.com/-BcN9AlIAFQA/AAAAAAAAAAI/AAAAAAAAAAA/gBMSO8C5uuM/s28-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "authorChannelUrl": "http://www.youtube.com/channel/UCaWgtSpS-YGwD-0WEgQX0mg",
            "authorChannelId": {
              "value": "UCaWgtSpS-YGwD-0WEgQX0mg"
            },
            "videoId": "m4Jtj2lCMAA",
            "textDisplay": "test",
            "textOriginal": "test",
            "canRate": true,
            "viewerRating": "none",
            "likeCount": 0,
            "publishedAt": "2018-01-11T06:11:55.000Z",
            "updatedAt": "2018-01-11T06:11:55.000Z"
          }
        },
        "canReply": true,
        "totalReplyCount": 0,
        "isPublic": true
      }
    }
  ]
}
EOL;
    }
}
