<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Comment extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::updated(function (Comment $comment) {
            $comment->likes()->create([
                'count' => $comment->total_likes
            ]);
        });
    }

    /**
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * @var array
     */
    protected $fillable = ['comment_id', 'author_id', 'text', 'created_at', 'total_likes'];

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
        return $this->hasMany(CommentLike::class, 'comment_id', 'comment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
