<?php

use App\Entities\{
    Channel, ChannelReport
};
use App\User;
use Faker\Generator as Faker;

$factory->define(ChannelReport::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        }
    ];
});
