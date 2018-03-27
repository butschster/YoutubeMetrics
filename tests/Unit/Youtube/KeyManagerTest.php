<?php

namespace Tests\Unit\Youtube;

use App\Contracts\Services\Youtube\KeyManager;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class KeyManagerTest extends TestCase
{
    use RefreshDatabase;

    function test_calculates_minutes_to_pt_lt()
    {
        $manager = $this->app->make(KeyManager::class);

        $minutes = $manager->calculateMinutesToPT(Carbon::createFromTime(9, 0, 0));

        $this->assertEquals(60, $minutes);
    }

    function test_calculates_minutes_to_pt_gt()
    {
        $manager = $this->app->make(KeyManager::class);

        $minutes = $manager->calculateMinutesToPT(Carbon::createFromTime(12, 0, 0));

        $this->assertEquals(22 * 60, $minutes);
    }

    function test_check_key_is_banned()
    {
        $this->createYoutubeKey(['key' => 'key1']);
        $this->createYoutubeKey(['key' => 'key2']);

        $manager = $this->app->make(KeyManager::class);

        $manager->ban('key1');

        $this->assertTrue($manager->isBanned('key1'));
        $this->assertFalse($manager->isBanned('key2'));
        $this->assertEquals(['key2'], $manager->keys());
    }

    function test_bans_key()
    {
        $manager = $this->app->make(KeyManager::class);

        Cache::shouldReceive('put')
            ->once()
            ->with(md5('youtube.bankey1'), 1, 10 * 60);

        $manager->ban('key1', Carbon::createFromTime(24, 0, 0));
    }

    function test_caches_keys()
    {
        Cache::shouldReceive('rememberForever')->once()->andReturn(['key1']);
        Cache::shouldReceive('has')->once()->andReturn(false);

        $manager = $this->app->make(KeyManager::class);

        $this->assertEquals(['key1'], $manager->keys());
    }
}
