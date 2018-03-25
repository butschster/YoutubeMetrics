<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\ {
    HasMany, HasOne
};

class FollowedChannel extends Model
{
    const UPDATED_AT = null;

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

    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'follow_to' => 'date',
        'title' => 'string'
    ];

    /**
     * @return bool
     */
    public function isFollow(): bool
    {
        if (!$this->follow_to) {
            return true;
        }

        return $this->follow_to->endOfDay()->gte(now());
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlyFollow(Builder $builder)
    {
        return $builder->where(function ($query) {
            return $query
                ->orWhereNull('follow_to')
                ->orWhere('follow_to', '>=', now()->toDateString());
        });
    }

    /**
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'channel_id');
    }

    /**
     * @return HasOne
     */
    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class, 'id');
    }
}
