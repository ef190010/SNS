<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'body' => $faker->text($maxNbChars = 200),
        'prefs' => $faker->numberBetween($min = 0, $max = 47),
        'categories' => $faker->numberBetween($min = 21, $max = 26),
        'created_at' => now(),
        'updated_at' => now(),
        
    ];
});
