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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'role' => $faker->randomElement(['Student', 'HOD', 'VP']),
        'Phone_No' => $faker->unique()->phoneNumber,
        'api_token' => str_random(49),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Permission::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1,50),
        'room_id' => $faker->numberBetween(1,50),
        'purpose' => $faker->paragraph,
        'special notes' => $faker->paragraph,
        'start_date' => $faker->date('Y-m-d', '+1 year'),
        'end_date' => $faker->date('Y-m-d', '+1 year'),
        'start_time' => $faker->time('H:i:s', 'now'),
        'end_time' => $faker->time('H:i:s', 'now'),
        'permission_hod' => $faker->randomElement(['1', '0']),
        'permission_vp' => $faker->randomElement(['1', '0']),
    ];
});

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'room_no' => rand(1, 50),
        'hod_id' => rand(1, 9),
        'description' => $faker->paragraph,
        'multiple' => $faker->randomElement(['1', '0']),
    ];
});

//123