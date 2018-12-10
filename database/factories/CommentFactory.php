<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Comment::class, function (Faker $faker) {
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'content' => $faker->text,
        'author' => $faker->name,
        'email' => $faker->email,
        'website' => $faker->url,
        'created_at' => $created_at,
        'updated_at' => $updated_at
    ];
});
