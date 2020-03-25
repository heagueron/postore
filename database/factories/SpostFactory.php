<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Spost;
use Faker\Generator as Faker;

$factory->define(Spost::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence()
    ];
});
