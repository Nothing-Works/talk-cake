<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        'visits' => 0,
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(App\Channel::class)->create()->id;
        },
    ];
});
