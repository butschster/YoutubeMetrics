<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class CommentLike extends Model
{

    /**
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    const UPDATED_AT = null;

    /**
     * @var array
     */
    protected $fillable = ['count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
