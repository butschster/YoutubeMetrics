<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;

class Bot extends YoutubeModel
{
    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeLive(Builder $builder)
    {
        return $builder->where('deleted', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'channel_id');
    }
}
