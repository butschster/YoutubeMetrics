<?php

use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\Video;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'video_id' => function () {
            return factory(Video::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        },
        'text' => $faker->paragraph,
        'total_likes' => $faker->randomNumber(),
        'is_spam' => $faker->boolean
    ];
});
