<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Course::class, function (Faker $faker) {
    return [
        'subject_id' => function () {
            return factory(App\Models\Subject::class)->create()->id;
        },
        'semester_id' => function () {
            return factory(App\Models\Semester::class)->create()->id;
        },
        'syllabus_th' => $faker->text($maxNbChars = 200),
        'syllabus_en' => $faker->text($maxNbChars = 200),
        'sec' => 'Section' . $faker->numberBetween($min = 1, $max = 5)
    ];
});
