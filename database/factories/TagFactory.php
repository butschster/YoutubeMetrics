<?php

use App\Entities\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'created_at' => $faker->dateTime
    ];
});
