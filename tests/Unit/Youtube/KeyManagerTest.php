<?php

namespace Tests\Unit\Youtube;

use App\Contracts\Services\Youtube\KeyManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class KeyManagerTest extends TestCase
{
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
        $manager = $this->app->make(KeyManager::class);
        $manager->setKeys([
            'key1',
            'key2'
        ]);

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
}
