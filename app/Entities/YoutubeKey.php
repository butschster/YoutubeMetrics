<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class YoutubeKey extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function (YoutubeKey $key) {
            $key->clearCache();
        });

        static::deleted(function (YoutubeKey $key) {
            $key->clearCache();
        });
    }

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['key'];

    /**
     * Получение списка всех ключей
     *
     * @return array
     */
    public static function getKeys(): array
    {
        return Cache::rememberForever(static::getCacheKey(), function () {
            return static::pluck('key')->all();
        });
    }

    public function clearCache(): void
    {
        Cache::forget(static::getCacheKey());
    }

    /**
     * @return string
     */
    protected static function getCacheKey(): string
    {
        return md5('api-keys');
    }
}
