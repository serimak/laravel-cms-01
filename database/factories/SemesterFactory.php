<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Semester::class, function (Faker $faker) {
    return [
        'year' => $faker->year($max = 'now'),
        'term' => $faker->numberBetween($min = 1, $max = 2)
    ];
});
