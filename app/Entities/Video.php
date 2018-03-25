<?php

namespace App\Entities;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statistics()
    {
        return $this->hasMany(VideoStat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
