<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Subject::class, function (Faker $faker) {
    return [
        'id' => 'Code' . $faker->numberBetween($min = 1, $max = 20),
        'faculty_id' => function () {
            return factory(App\Models\Faculty::class)->create()->id;
        },
        'major_id' => function () {
            return factory(App\Models\Major::class)->create()->id;
        },
        'name_th'=> $faker->name,
        'name_en'=> $faker->name,
        'credits'=> $faker->numberBetween($min = 1, $max = 4),
    ];
});
