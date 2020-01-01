<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        //
        'content' => $faker->paragraph(3, true),
        'created_at' => $faker->dateTimeBetween('-3 months'),
    ];
});
