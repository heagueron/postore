<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Remjob;
use Faker\Generator as Faker;


$factory->define(Remjob::class, function (Faker $faker) {


    return [
        'company_name'  => $faker->company,
        'position'      => $faker->randomElement(['administrator', 'operator', 'developer', 'devops', 'designer', 'coach']),
        'category_id'   => $faker->randomElement(['1', '2', '3', '4', '5', '6']),
        'text'          => $faker->text($maxNbChars = 200),
        'location'      => $faker->country,
    ];
});

