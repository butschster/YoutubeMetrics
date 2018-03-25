<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\{
    BelongsTo, BelongsToMany, HasMany
};
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
