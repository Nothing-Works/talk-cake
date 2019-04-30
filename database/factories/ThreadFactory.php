<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Thread::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'slug' => Str::slug($title),
        'visits' => 0,
        'title' => $title,
        'body' => $faker->paragraph,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(App\Channel::class)->create()->id;
        },
    ];
});
