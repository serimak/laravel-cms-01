<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Mobile::class, function (Faker $faker) {
    return [
        //
        'user_id' => 'st0123',
        'mobile' => $faker->phoneNumber,
        'status' => 'Primary',
    ];
});
