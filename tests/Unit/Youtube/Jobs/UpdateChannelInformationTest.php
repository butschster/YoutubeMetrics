<?php

namespace Tests\Unit\Youtube\Jobs;

use App\Entities\Channel;
use App\Jobs\Youtube\UpdateChannelInformation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Unit\Youtube\FakeClient;

class UpdateChannelInformationTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    function test_handle()
    {
        $channel = $this->createChannel([
            'id' => 'UC__R_ZSQ5SwasiqeJ5-nqZQ',
            'name' => null,
            'thumb' => null,
            'country' => null,
            'reports' => 0,
            'views' => 0,
            'comments' => 0,
            'subscribers' => 0,
            'total_comments' => 0,
            'bot_comments' => 0
        ]);

        $channelForDelete = $this->createChannel([
            'id' => 'UC__R_ZSQ5SwasiqeJ5-nqZ1',
            'deleted' => false
        ]);

        $this->assertEquals(0, $channel->statistics()->count());

        $job = new UpdateChannelInformation([$channel->id, 'UC__srCovAWzwj4Ujg5GQJxQ', 'UC__R_ZSQ5SwasiqeJ5-nqZ1']);

        $client = new FakeClient();
        $client->shouldReturn(function(array $params) {
            return $this->youtubeResponse($params);
        });

        $job->handle($client);
        $channel = $channel->fresh();

        $this->assertEquals('Хасанали Гаюрович', $channel->name);
        $this->assertEquals('2018-03-14 11:39:53', $channel->created_at->toDateTimeString());
        $this->assertEquals('https://yt3.ggpht.com/-qhbH3cVVEUs/AAAAAAAAAAI/AAAAAAAAAAA/hD4BG3zaUgs/s240-c-k-no-mo-rj-c0xffffff/photo.jpg', $channel->thumb);
        $this->assertEquals('US', $channel->country);

        $this->assertEquals(1000, $channel->views);
        $this->assertEquals(10000, $channel->comments);
        $this->assertEquals(100, $channel->subscribers);
        $this->assertEquals(1, $channel->statistics()->count());

        $newChannel = Channel::findOrFail('UC__srCovAWzwj4Ujg5GQJxQ');

        $this->assertEquals('Игорь Московский', $newChannel->name);
        $this->assertEquals('2011-06-14 14:27:52', $newChannel->created_at->toDateTimeString());
        $this->assertEquals('https://yt3.ggpht.com/-AbxrsaGf_8s/AAAAAAAAAAI/AAAAAAAAAAA/6qUTV6KG8zA/s240-c-k-no-mo-rj-c0xffffff/photo.jpg', $newChannel->thumb);
        $this->assertEquals('RU', $newChannel->country);

        $this->assertEquals(2673, $newChannel->views);
        $this->assertEquals(0, $newChannel->comments);
        $this->assertEquals(2, $newChannel->subscribers);

        $this->assertEquals(1, $newChannel->statistics()->count());

        $channelForDelete = $channelForDelete->fresh();
        $this->assertTrue($channelForDelete->deleted);
    }

    protected function youtubeResponse(array $params)
    {
        return <<<EOL
{
  "kind": "youtube#channelListResponse",
  "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/8DGoa2uxsE9eF-apKC9WI27BSIo\"",
  "pageInfo": {
    "totalResults": 2,
    "resultsPerPage": 2
  },
  "items": [
    {
      "kind": "youtube#channel",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/RVheuKKE3iJnZz1mjdigykcTnwM\"",
      "id": "UC__R_ZSQ5SwasiqeJ5-nqZQ",
      "snippet": {
        "title": "Хасанали Гаюрович",
        "description": "",
        "country": "US",
        "publishedAt": "2018-03-14T11:39:53.000Z",
        "thumbnails": {
          "default": {
            "url": "https://yt3.ggpht.com/-qhbH3cVVEUs/AAAAAAAAAAI/AAAAAAAAAAA/hD4BG3zaUgs/s88-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "width": 88,
            "height": 88
          },
          "medium": {
            "url": "https://yt3.ggpht.com/-qhbH3cVVEUs/AAAAAAAAAAI/AAAAAAAAAAA/hD4BG3zaUgs/s240-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "width": 240,
            "height": 240
          },
          "high": {
            "url": "https://yt3.ggpht.com/-qhbH3cVVEUs/AAAAAAAAAAI/AAAAAAAAAAA/hD4BG3zaUgs/s800-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "width": 800,
            "height": 800
          }
        },
        "localized": {
          "title": "Хасанали Гаюрович",
          "description": ""
        }
      },
      "contentDetails": {
        "relatedPlaylists": {
          "uploads": "UU__R_ZSQ5SwasiqeJ5-nqZQ",
          "watchHistory": "HL",
          "watchLater": "WL"
        }
      },
      "statistics": {
        "viewCount": "1000",
        "commentCount": "10000",
        "subscriberCount": "100",
        "hiddenSubscriberCount": false,
        "videoCount": "1500"
      }
    },
    {
      "kind": "youtube#channel",
      "etag": "\"RmznBCICv9YtgWaaa_nWDIH1_GM/Z4w-UxnsKG60aGqYQF98B1G5LVo\"",
      "id": "UC__srCovAWzwj4Ujg5GQJxQ",
      "snippet": {
        "title": "Игорь Московский",
        "description": "",
        "publishedAt": "2011-06-14T14:27:52.000Z",
        "thumbnails": {
          "default": {
            "url": "https://yt3.ggpht.com/-AbxrsaGf_8s/AAAAAAAAAAI/AAAAAAAAAAA/6qUTV6KG8zA/s88-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "width": 88,
            "height": 88
          },
          "medium": {
            "url": "https://yt3.ggpht.com/-AbxrsaGf_8s/AAAAAAAAAAI/AAAAAAAAAAA/6qUTV6KG8zA/s240-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "width": 240,
            "height": 240
          },
          "high": {
            "url": "https://yt3.ggpht.com/-AbxrsaGf_8s/AAAAAAAAAAI/AAAAAAAAAAA/6qUTV6KG8zA/s800-c-k-no-mo-rj-c0xffffff/photo.jpg",
            "width": 800,
            "height": 800
          }
        },
        "localized": {
          "title": "Игорь Московский",
          "description": ""
        }
      },
      "contentDetails": {
        "relatedPlaylists": {
          "uploads": "UU__srCovAWzwj4Ujg5GQJxQ",
          "watchHistory": "HL",
          "watchLater": "WL"
        }
      },
      "statistics": {
        "viewCount": "2673",
        "commentCount": "0",
        "subscriberCount": "2",
        "hiddenSubscriberCount": false,
        "videoCount": "8"
      }
    }
  ]
}
EOL;
    }
}
