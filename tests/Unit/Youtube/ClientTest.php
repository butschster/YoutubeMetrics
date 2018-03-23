<?php

namespace Tests\Unit\Youtube;

use App\Contracts\Services\Youtube\Client;
use App\Contracts\Services\Youtube\KeyManager;
use App\Services\Youtube\DailyLimitExceededException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;
use Mockery as m;

class ClientTest extends TestCase
{

    function test_ban_key_if_daily_limit_exceeded()
    {
        $manager = $this->app->make(KeyManager::class);
        $manager->setKeys(['key1']);

        $client = $this->app->make(Client::class);

        $this->assertFalse($manager->isBanned('key1'));

        $client->setHttpClient($httpClient = m::mock(\GuzzleHttp\ClientInterface::class));

        $httpClient->shouldReceive('get')->andReturnUsing(function () {
            throw new ClientException(
                'The request cannot be completed because you have exceeded your <a href="/youtube/v3/getting-started#quota">quota</a>.',
                m::mock(RequestInterface::class),
                new Response(403, [], json_encode([
                    'error' => [
                        'code' => 500,
                        'message' => 'The request cannot be completed because you have exceeded your <a href="/youtube/v3/getting-started#quota">quota</a>.',
                        'errors' => [
                            [
                                'reason' => 'dailyLimitExceeded',
                                'message' => 'Test message'
                            ]
                        ]
                    ]

                ]))
            );
        });

        try {
            $client->getVideoInfo('test');
        } catch (\Exception $e) {
            $this->assertInstanceOf(DailyLimitExceededException::class, $e);
        }

        $this->assertTrue($manager->isBanned('key1'));
        $this->assertCount(0, $manager->keys());
    }
}
