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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'first_name'           => $faker->firstName,
        'last_name'            => $faker->lastName,
        'email'                => $faker->unique()->safeEmail,
        'gender'               => 'other',
    ];
});

$factory->state(App\User::class, 'male', [
    'gender' => 'male',
]);

$factory->state(App\User::class, 'female', [
    'gender' => 'female',
]);
