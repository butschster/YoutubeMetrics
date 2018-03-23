<?php

namespace Tests\Unit\Youtube\Jobs;

use App\Jobs\Youtube\SyncVideoComments;
use App\Jobs\Youtube\UpdateComments;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\Youtube\FakeClient;

class SyncVideoCommentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public $video;

    function test_handle()
    {
        Bus::fake();

        $this->video = $this->createVideo();

        $job = new SyncVideoComments($this->video);

        $this->assertEquals($this->video->id, $job->video);
        $this->assertEquals('comment', $job->queue);

        $client = new FakeClient();
        $client->shouldReturn(function (array $params) {
            return $this->youtubeResponse($params);
        });

        $job->handle($client);

        Bus::assertDispatched(UpdateComments::class, 2);
    }

    private function youtubeResponse(array $params)
    {
        $this->assertEquals($this->video->id, $params['videoId']);

        if (isset($params['pageToken']) && $params['pageToken'] == 'next_page') {
            return <<<ABC
{
  "kind": "youtube#commentThreadListResponse",
  "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/J4VtO1aVIYWXz9aDwxpTez5X60E\"",
  "pageInfo": {
    "totalResults": 19,
    "resultsPerPage": 20
  },
  "items": [
    {
      "kind": "youtube#commentThread",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/qwst5G8FdLsuJ5ibcFNmSFL0_Eo\"",
      "id": "Ugw_RkyBLegSbfebn454AaABAg",
      "snippet": {
        "videoId": "m4Jtj2lCMAA",
        "topLevelComment": {
          "kind": "youtube#comment",
          "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/HDBXRLohLI5mF5w88XvduWw4grk\"",
          "id": "Ugw_RkyBLegSbfebn454AaABAg",
          "snippet": {
            "authorDisplayName": "Rajesh Kumar",
            "authorProfileImageUrl": "https://yt3.ggpht.com/-liiF_vYRPTQ/AAAAAAAAAAI/AAAAAAAAAAA/_rRK6EUJK2U/s28-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "authorChannelUrl": "http://www.youtube.com/channel/UCaRCHE1__9ZMVq7LWaZwPWQ",
            "authorChannelId": {
              "value": "UCaRCHE1__9ZMVq7LWaZwPWQ"
            },
            "videoId": "m4Jtj2lCMAA",
            "textDisplay": "first updated top level comment in comment threads",
            "textOriginal": "first updated top level comment in comment threads",
            "canRate": true,
            "viewerRating": "none",
            "likeCount": 0,
            "publishedAt": "2017-12-12T06:50:24.000Z",
            "updatedAt": "2017-12-12T06:53:30.000Z"
          }
        },
        "canReply": true,
        "totalReplyCount": 0,
        "isPublic": true
      }
    },
    {
      "kind": "youtube#commentThread",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/v2xgkH7sX-r0eJIjdbivOHyRIGI\"",
      "id": "UgwCnjEVG4VxU7CpFQd4AaABAg",
      "snippet": {
        "videoId": "m4Jtj2lCMAA",
        "topLevelComment": {
          "kind": "youtube#comment",
          "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/s22a3rVcmBeuq33Jlp8lCad0HXA\"",
          "id": "UgwCnjEVG4VxU7CpFQd4AaABAg",
          "snippet": {
            "authorDisplayName": "꧁Euphoric Tingles ASMR꧂",
            "authorProfileImageUrl": "https://yt3.ggpht.com/-4xNAFdUaorM/AAAAAAAAAAI/AAAAAAAAAAA/XumhiORwbBc/s28-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "authorChannelUrl": "http://www.youtube.com/channel/UCws-p_JylihpiDN0hnrDR4Q",
            "authorChannelId": {
              "value": "UCws-p_JylihpiDN0hnrDR4Q"
            },
            "videoId": "m4Jtj2lCMAA",
            "textDisplay": "NICE",
            "textOriginal": "NICE",
            "canRate": true,
            "viewerRating": "none",
            "likeCount": 0,
            "publishedAt": "2017-11-17T20:04:43.000Z",
            "updatedAt": "2017-11-17T20:04:43.000Z"
          }
        },
        "canReply": true,
        "totalReplyCount": 0,
        "isPublic": true
      }
    }
  ]
}
ABC;
        }
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
