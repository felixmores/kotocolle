<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->text,
    ];
});

$factory->state(App\Models\Comment::class, 'word_id:2, user_id:2' ,function (Faker $faker) {
    return [
        'id' => 2,
        'comment' => 'テストコメントです',
        'user_id' => 2,
        'word_id' => 2,
    ];
});

$factory->state(App\Models\Comment::class, 'word_id:3, user_id:3' ,function (Faker $faker) {
    return [
        'id' => 3,
        'comment' => 'テストコメントです',
        'user_id' => 3,
        'word_id' => 3,
    ];
});