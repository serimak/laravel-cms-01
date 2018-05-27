<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'id' => $faker->unique()->userName,

        'title_id' => function () {
            return factory(App\Models\Title::class)->create()->id;
        },
        'major_id' => function () {
            return factory(App\Models\Major::class)->create()->id;
        },
        'faculty_id' => function (array $user) {
            return App\Models\Major::find($user['major_id'])->faculty_id;
        },

        'first_name_th'=> $faker->firstname,
        'first_name_en'=> $faker->firstname,
        'last_name_th'=> $faker->lastname,
        'last_name_en'=> $faker->lastname,
        'password' => bcrypt('password'),
        'card_issue_date' => '20/01/2017',
        'card_expiry_date' => '20/01/2020',
        'gender' => $faker->randomElement(array('Male', 'Female')),
        'birthdate' => Carbon::now(),
        'id_card_no' => '1111222233334',
        'nationality' => 'Thai',
        'profile_image_url' => 'https://images.vexels.com/media/users/3/129616/isolated/preview/fb517f8913bd99cd48ef00facb4a67c0-businessman-avatar-silhouette-by-vexels.png',
        'transcript_url' => 'https://images.vexels.com/media/users/3/129616/isolated/preview/fb517f8913bd99cd48ef00facb4a67c0-businessman-avatar-silhouette-by-vexels.png',
        'year' => '2017',
        'status' => 'Active'
    ];
});
