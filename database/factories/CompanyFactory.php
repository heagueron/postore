<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {

    $companyName = $faker->unique()->company;

    return [
        'name'      => $companyName,
        'slug'      => Str::slug($companyName, '-'),
        'email'     => $faker->email,
        'user_id'   => 1,
        'logo'      => $faker->randomElement(['logos/logo1.png', 'logos/logo2.png', 'logos/logo3.png', 'logos/logo4.png', null]),
    ];
});
