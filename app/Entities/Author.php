<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Author extends Model
{
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
    protected $guarded = [];

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
     * @param int $score
     */
    public function updateReports(int $score)
    {
        if (is_null($this->reports)) {
            $this->reports = 0;
        }

        if ($score > 0) {
            $this->reports += $score;
        } else if ($this->reports > ($score * -1)) {
            $this->reports -= ($score * -1);
        }

        $this->save();
    }

    public function markAsBot()
    {
        $this->bot = true;
        $this->save();

        $this->comments()->update(['spam' => true]);
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
        return $this->hasMany(Comment::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'channel_id');
    }
}
