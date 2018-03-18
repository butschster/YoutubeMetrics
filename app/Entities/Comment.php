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
            $comment->is_spam = Author::onlyBots()->live()->where('id', $comment->channel_id)->exists();
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
        return $this->created_at->format('d.m.Y H:i:s');
    }

    /**
     * @param Builder $builder
     * @param string|Author $author
     * @return $this
     */
    public function scopeFilterByChannel(Builder $builder, $author)
    {
        if ($author instanceof Author) {
            $author = $author->getKey();
        }

        return $this->where('channel_id', $author);
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

        return $this->where('video_id', $video);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlySpam(Builder $builder)
    {
        return $this->where('is_spam', true);
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
    public function author()
    {
        return $this->belongsTo(Author::class, 'channel_id');
    }
}
