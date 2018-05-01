<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo, HasMany
};
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Comment extends YoutubeModel
{
    use HybridRelations;

    /**
     * @var array
     */
    protected $casts = [
        'is_spam' => 'bool',
        'text' => 'string',
        'total_likes' => 'int',
    ];

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
     * @return BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
