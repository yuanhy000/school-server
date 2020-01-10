<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Commodity;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Commodity::class, function (Faker $faker) {
    return [

        'name' => $faker->name,
        'description' => $faker->paragraph,
        'price' => $faker->randomFloat(2, 20, 500),
        'user_id' => 4,
        'phone' => $faker->unique()->phoneNumber,
        'email_verified_at' => now(),
        'sex' => $faker->numberBetween(0, 1),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'avatar' => $faker->imageUrl(100, 100),
    ];
});
