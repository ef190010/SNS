<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name(),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'nickname' => $faker->name(),
        'icon' => 'https://my-sns-backet.s3.ap-northeast-1.amazonaws.com/systems/default_icon.jpg',
        'profile' => $faker->text($maxNbChars = 200),
        'prefs' => $faker->numberBetween($min = 0, $max = 47),
        'categories' => $faker->numberBetween($min = 21, $max = 26),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
