<?php

use App\Entities\Channel;
use App\Entities\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'views' => $faker->randomNumber(),
        'likes' => $faker->randomNumber(),
        'dislikes' => $faker->randomNumber(),
        'comments' => $faker->randomNumber(),
        'favorites' => $faker->randomNumber(),
        'thumb' => $faker->imageUrl(400, 400),
        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        },
        'created_at' => $faker->dateTime
    ];
});
