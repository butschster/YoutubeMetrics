<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChannelReport extends Model
{
    protected $fillable = ['user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
