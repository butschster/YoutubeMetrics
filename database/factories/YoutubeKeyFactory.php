<?php

use App\Entities\YoutubeKey;
use Faker\Generator as Faker;

$factory->define(YoutubeKey::class, function (Faker $faker) {
    return [
        'key' => $faker->uuid
    ];
});
