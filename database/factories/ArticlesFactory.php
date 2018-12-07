<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Article::class, function (Faker $faker) {
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    $isHidden = [0, 1];
    return [
        'title' => $faker->sentence,
        'content_html' => $faker->text,
        'content_markdown' => $faker->text,
        'cover' => 'http://www.baidu.com',
        'created_at' => $created_at,
        'updated_at' => $updated_at,
        'is_hidden' => $faker->randomElement($isHidden)
    ];
});
