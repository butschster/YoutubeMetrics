<?php

namespace App\Entities;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;

class MongodbModel extends Model
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

    /**
     * @inheritdoc
     */
//    protected function asDateTime($value)
//    {
//        $date = parent::asDateTime($value);
//
//        $date->setTimezone(new \DateTimeZone(config('app.timezone')));
//
//        return $date;
//    }
}