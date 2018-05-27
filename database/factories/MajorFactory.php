<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Major::class, function (Faker $faker) {

    return [
        'id' => $faker->unique()->randomNumber,
        'faculty_id' => function () {
            return factory(App\Models\Faculty::class)->create()->id;
        },
        'name_th'=> $faker->name,
        'name_en'=> $faker->name
    ];
});
