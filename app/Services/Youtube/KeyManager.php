<?php

namespace App\Services\Youtube;

use App\Contracts\Services\Youtube\KeyManager as KeyManagerContract;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cache;

class KeyManager implements KeyManagerContract
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $keys = [];

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Поверка на наличие ключей
     *
     * @return bool
     */
    public function hasKeys(): bool
    {
        return count($this->keys()) > 0;
    }

    /**
     * @return null|string
     */
    public function randomKey(): ?string
    {
        $keys = $this->keys();

        if (empty($keys)) {
            return null;
        }

        if (count($keys) === 1) {
            return array_first($keys);
        }

        return $keys[array_rand($keys)];
    }

    /**
     * @param array $keys
     */
    public function setKeys(array $keys): void
    {
        $this->keys = $keys;
    }

    /**
     * @return array
     */
    public function keys(): array
    {
        return collect($this->keys)
            ->filter(function ($key) {
                return !$this->isBanned($key);
            })
            ->values()
            ->all();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isBanned(string $key): bool
    {
        return Cache::has(
            $this->cacheKey($key)
        );
    }

    /**
     * @param string $key
     * @param Carbon|null $date
     */
    public function ban(string $key, Carbon $date = null): void
    {
        Cache::put($this->cacheKey($key), 1, $this->calculateMinutesToPT($date ?: now()));
    }

    /**
     * @param string $key
     * @return string
     */
    protected function cacheKey(string $key): string
    {
        return md5('youtube.ban'.$key);
    }

    /**
     * @param Carbon $date
     * @return int
     */
    public function calculateMinutesToPT(Carbon $date): int
    {
        $pt = Carbon::createFromTime(10, 0, 0);

        if ($date->lt($pt)) {
            return $date->diffInMinutes($pt);
        }

        return $date->diffInMinutes($pt->addDay());
    }
}