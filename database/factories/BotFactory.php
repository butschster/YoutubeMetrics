<?php

use App\Entities\Bot;
use Faker\Generator as Faker;

$factory->define(Bot::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'deleted' => $faker->boolean
    ];
});
