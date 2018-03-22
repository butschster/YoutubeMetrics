<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
        'follow' => 'bool',
        'title' => 'string'
    ];

    public function isFollow(): bool
    {
        return $this->follow;
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlyFollow(Builder $builder)
    {
        return $builder->where('follow', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function channel()
    {
        return $this->hasOne(Channel::class, 'id');
    }
}
