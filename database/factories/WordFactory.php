<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Word::class, function (Faker $faker) {
    return [
        'word' => $faker->word,
    ];
});

$factory->state(App\Models\Word::class, 'id:2, user_id:2' ,function (Faker $faker) {
    return [
        'id' => 2,
        'user_id' => 2,
    ];
});

$factory->state(App\Models\Word::class, 'id:3, user_id:3, share_flag:1' ,function (Faker $faker) {
    return [
        'id' => 3,
        'user_id' => 3,
        'share_flag' => 1,
    ];
});

$factory->state(App\Models\Word::class, 'id:4, user_id:4, share_flag:0' ,function (Faker $faker) {
    return [
        'id' => 4,
        'user_id' => 4,
        'share_flag' => 0,
    ];
});