<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class ChannelStat extends Model
{
    const UPDATED_AT = null;

    /**
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * @var array
     */
    protected $guarded = [];
}
