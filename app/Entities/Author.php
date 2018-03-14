<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Author extends Model
{
    use HybridRelations;

    protected static function boot()
    {
        parent::boot();

        static::saved(function (Author $author) {
            Cache::forget('author:'.$author->id);
        });
    }

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
    protected $fillable = ['id', 'total_comments', 'bot', 'deleted', 'created_at'];

    /**
     * @return string
     */
    public function type(): string
    {
        if ($this->bot) {
            return 'bot';
        }

        if ($this->reports > 0) {
            return 'reported';
        }

        return 'normal';
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeLive(Builder $builder)
    {
        return $builder->where('deleted', false);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlyBots(Builder $builder)
    {
        return $builder->where('bot', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }
}
