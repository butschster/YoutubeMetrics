<?php

namespace Tests\Unit\Youtube\Jobs;

use App\Jobs\Youtube\UpdateVideoInformation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\Youtube\FakeClient;

class UpdateVideoInformationTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    function test_handle()
    {
        Bus::fake();

        $video = $this->createVideo([
            'id' => 'Ks-_Mh1QhMc'
        ]);

        $job = new UpdateVideoInformation($video);

        $this->assertEquals($video->id, $job->video);
        $this->assertEquals('video', $job->queue);
        $this->assertEquals(0, $video->statistics()->count());

        $client = new FakeClient();
        $client->shouldReturn(function (array $params) {
            return $this->youtubeResponse($params);
        });

        $job->handle($client);

        $video = $video->fresh();

        $this->assertEquals(12, $video->tags()->count());

        $this->assertEquals('Your body language may shape who you are', $video->title);
        $this->assertEquals('Body language affects how others see us, but it may also change how we see ourselves.', $video->description);
        $this->assertEquals('https://i.ytimg.com/vi/Ks-_Mh1QhMc/hqdefault.jpg', $video->thumb);

        $this->assertEquals(14003757, $video->views);
        $this->assertEquals(181654, $video->likes);
        $this->assertEquals(3456, $video->dislikes);
        $this->assertEquals(6896, $video->comments);
        $this->assertEquals(0, $video->favorites);

        $this->assertEquals(1, $video->statistics()->count());
    }

    function test_handle_with_not_exists_video_in_database()
    {
        Bus::fake();

        $job = new UpdateVideoInformation('test');

        $client = new FakeClient();
        $client->shouldReturn(function (array $params) {
            return $this->youtubeEmptyResponse($params);
        });

        Log::shouldReceive('debug')->once()->with("Video with id [test] not found.");
        $job->handle($client);
    }

    function test_handle_with_not_exists_video_on_youtube()
    {
        Bus::fake();

        $video = $this->createVideo([
            'title' => $title = 'test title'
        ]);

        $job = new UpdateVideoInformation($video);

        $client = new FakeClient();
        $client->shouldReturn(function (array $params) {
            return $this->youtubeEmptyResponse();
        });

        Log::shouldReceive('debug')->once()->with("Youtube: video with id [{$video->id}] not found.");
        $job->handle($client);
        $this->assertEquals($title, $video->title);
    }

    protected function youtubeEmptyResponse()
    {
        return <<<EOL
{
  "kind": "youtube#videoListResponse",
  "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/x1612UHw7s0McEtlNxyZQ0_mcuQ\"",
  "pageInfo": {
    "totalResults": 0,
    "resultsPerPage": 0
  },
  "items": []
}
EOL;

    }

    protected function youtubeResponse(array $params)
    {
        $this->assertEquals('Ks-_Mh1QhMc', $params['id']);
        
        return <<<EOL
{
  "kind": "youtube#videoListResponse",
  "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/CbOpuMHMINWgR9SFIb29nvun0f0\"",
  "pageInfo": {
    "totalResults": 1,
    "resultsPerPage": 1
  },
  "items": [
    {
      "kind": "youtube#video",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/Y35MtPieWzVS4iQN5_tgAWsoQhw\"",
      "id": "Ks-_Mh1QhMc",
      "snippet": {
        "publishedAt": "2012-10-01T15:27:35.000Z",
        "channelId": "UCAuUUnT6oDeKwE6v1NGQxug",
        "title": "Your body language may shape who you are",
        "description": "Body language affects how others see us, but it may also change how we see ourselves.",
        "thumbnails": {
          "default": {
            "url": "https://i.ytimg.com/vi/Ks-_Mh1QhMc/default.jpg",
            "width": 120,
            "height": 90
          },
          "medium": {
            "url": "https://i.ytimg.com/vi/Ks-_Mh1QhMc/mqdefault.jpg",
            "width": 320,
            "height": 180
          },
          "high": {
            "url": "https://i.ytimg.com/vi/Ks-_Mh1QhMc/hqdefault.jpg",
            "width": 480,
            "height": 360
          },
          "standard": {
            "url": "https://i.ytimg.com/vi/Ks-_Mh1QhMc/sddefault.jpg",
            "width": 640,
            "height": 480
          },
          "maxres": {
            "url": "https://i.ytimg.com/vi/Ks-_Mh1QhMc/maxresdefault.jpg",
            "width": 1280,
            "height": 720
          }
        },
        "channelTitle": "TED",
        "tags": [
          "Amy Cuddy",
          "TED",
          "TEDTalk",
          "TEDTalks",
          "TED Talk",
          "TED Talks",
          "TEDGlobal",
          "brain",
          "business",
          "psychology",
          "self",
          "success"
        ],
        "categoryId": "22",
        "liveBroadcastContent": "none",
        "defaultLanguage": "en",
        "localized": {
          "title": "Your body language may shape who you are",
          "description": "Body language affects how others see us, but it may also change how we see ourselves."
        },
        "defaultAudioLanguage": "en"
      },
      "contentDetails": {
        "duration": "PT21M3S",
        "dimension": "2d",
        "definition": "hd",
        "caption": "true",
        "licensedContent": true,
        "projection": "rectangular"
      },
      "statistics": {
        "viewCount": "14003757",
        "likeCount": "181654",
        "dislikeCount": "3456",
        "favoriteCount": "0",
        "commentCount": "6896"
      }
    }
  ]
}
EOL;

    }
}
