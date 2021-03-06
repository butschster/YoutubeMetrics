<?php

use App\Entities\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'bot' => $faker->boolean,
        'verified' => $faker->boolean,
        'deleted' => $faker->boolean,
        'thumb' => $faker->imageUrl(400, 400),
        'name' => $faker->sentence,
        'total_reports' => $faker->randomNumber(),
        'views' => $faker->randomNumber(),
        'comments' => $faker->randomNumber(),
        'subscribers' => $faker->randomNumber(),
        'total_comments' => $faker->randomNumber(),
        'bot_comments' => $faker->randomNumber(),
        'created_at' => $faker->dateTime
    ];
});
