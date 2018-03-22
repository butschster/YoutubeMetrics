<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Comment extends Model
{
    use HybridRelations;

    protected static function boot()
    {
        parent::boot();

        static::updated(function (Comment $comment) {
            $comment->likes()->create([
                'count' => $comment->total_likes
            ]);
        });

        static::creating(function (Comment $comment) {
            $comment->is_spam = Channel::onlyBots()->live()->where('id', $comment->channel_id)->exists();
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
    public function getFormattedDateAttribute(): string
    {
        return format_date($this->created_at);
    }

    /**
     * Ссылка на канал на Youtube
     *
     * @return string
     */
    public function getYoutubeLinkAttribute(): string
    {
        return "https://www.youtube.com/watch?v={$this->video_id}&lc={$this->id}";
    }

    /**
     * @param Builder $builder
     * @param string|Channel $channel
     * @return $this
     */
    public function scopeFilterByChannel(Builder $builder, $channel)
    {
        if ($channel instanceof Channel) {
            $channel = $channel->getKey();
        }

        return $builder->where('channel_id', $channel);
    }

    /**
     * @param Builder $builder
     * @param string|Video $video
     * @return $this
     */
    public function scopeFilterByVideo(Builder $builder, $video)
    {
        if ($video instanceof Video) {
            $video = $video->getKey();
        }

        return $builder->where('video_id', $video);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlySpam(Builder $builder)
    {
        return $builder->where('is_spam', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
