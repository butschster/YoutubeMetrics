<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\{
    BelongsTo, BelongsToMany, HasMany
};
use Illuminate\Support\Facades\Cache;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Video extends YoutubeModel
{
    use HybridRelations;

    /**
     * @return string
     */
    public function getDiffDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Ссылка на канал на Youtube
     *
     * @return string
     */
    public function getYoutubeLinkAttribute(): string
    {
        return "https://www.youtube.com/watch?v={$this->id}";
    }


    /**
     * Получение кол-ва спам комментариев
     *
     * @return int
     */
    public function getSpamCommentsAttribute(): int
    {
        $cacheKey = md5("spamComment".$this->id);
        return Cache::remember($cacheKey, now()->addHour(), function ()  {
            return $this->comments()->where('is_spam', true)->count();
        });
    }

    /**
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return HasMany
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(VideoStat::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
