<?php

use App\Entities\FollowedChannel;
use Faker\Generator as Faker;

$factory->define(FollowedChannel::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'title' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'follow_to' => $faker->date()
    ];
});
